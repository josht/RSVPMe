<?php
/**
 * RSVPMe
 *
 * Copyright 2010 by Josh Tambunga <josh+rsvpme@joshsmind.com>
 *
 * RSVPMe is free software; you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * RSVPMe is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * RSVPMe; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * @package rsvpme
 */
/**
 * The base class for RSVPMe.
 *
 * @package rsvpme
 */
class RSVPMe {
    /**
     * @var int $debugTimer In debug mode, will monitor execution time.
     * @access public
     */
    public $debugTimer = false;
    /**
     * @var boolean $_initialized True if the class has been initialized
     */
    private $_initialized = false;


    /**
     * Construct an instance of RSVPMe
     * @param modX $modx
     * @param array $config
     */
    function __construct(modX &$modx,array $config = array()) {
        $this->modx =& $modx;

        $corePath = $this->modx->getOption('rsvpme.core_path',$config,$this->modx->getOption('core_path').'components/rsvpme/');
        $assetsUrl = $this->modx->getOption('rsvpme.assets_url',$config,$this->modx->getOption('assets_url').'components/rsvpme/');
        $connectorUrl = $assetsUrl.'connector.php';

        $this->config = array_merge(array(
            'assetsUrl' => $assetsUrl,
            'cssUrl' => $assetsUrl.'css/',
            'jsUrl' => $assetsUrl.'js/',
            'imagesUrl' => $assetsUrl.'images/',

            'connectorUrl' => $connectorUrl,

            'corePath' => $corePath,
            'modelPath' => $corePath.'model/',
            'chunksPath' => $corePath.'elements/chunks/',
            'chunkSuffix' => '.chunk.tpl',
            'snippetsPath' => $corePath.'elements/snippets/',
            'processorsPath' => $corePath.'processors/',

            'debug' => $this->modx->getOption('rsvpme.debug',null,false),
            'use_multibyte' => (boolean)$this->modx->getOption('use_multibyte',null,false),
            'encoding' => $this->modx->getOption('modx_charset',null,'UTF-8'),
        ),$config);

        $this->modx->addPackage('rsvpme',$this->config['modelPath']);
        $this->modx->lexicon->load('rsvpme:default');
        if ($this->config['debug']) {
            $this->startDebugTimer();
        }
    }

    /**
     * Initializes RSVPMe into different contexts.
     *
     * @access public
     * @param string $ctx The context to load. Defaults to web.
     */
    public function initialize($ctx = 'web') {
        switch ($ctx) {
            case 'mgr':
                if (!$this->modx->loadClass('rsvpme.request.RSVPMeControllerRequest',$this->config['modelPath'],true,true)) {
                    return 'Could not load controller request handler.';
                }
                $this->request = new RSVPMeControllerRequest($this);
                return $this->request->handleRequest();
            break;
            case 'connector':
                if (!$this->modx->loadClass('rsvpme.request.RSVPMeConnectorRequest',$this->config['modelPath'],true,true)) {
                    return 'Could not load connector request handler.';
                }
                $this->request = new RSVPMeConnectorRequest($this);
                return $this->request->handle();
            break;
            default:
                /* if you wanted to do any generic frontend stuff here.
                 * For example, if you have a lot of snippets but common code
                 * in them all at the beginning, you could put it here and just
                 * call $rsvpme->initialize($modx->context->get('key'));
                 * which would run this.
                 */
            break;
        }
    }

    /**
     * Loads the Validator class (from FormIt)
     *
     * @access public
     * @param $config array An array of configuration parameters for the
     * validator class
     * @return fiValidator An instance of the fiValidator class.
     */
    public function loadValidator($config = array()) {
        if (!$this->modx->loadClass('rsvpme.rsvpmeValidator',$this->config['modelPath'],true,true)) {
            $this->modx->log(modX::LOG_LEVEL_ERROR,'[RSVPMe] Could not load Validator class.');
            return false;
        }
        $this->validator = new rsvpmeValidator($this, $config);
        return $this->validator;
    }

    /**
     * Sends the user to the payment processor to pay the registration fee
     *
     * @access public
     */
    public function processPayment() {
        return true;
    }

    /**
     * Registers a customer for an event
     *
     * @access public
     * @param int $regtype The id of the regtype for which the user is registering
     * @param array $user An array containing 'name' & 'email' & 'paid' for the registration
     * @return boolean True if the user was successfully registered
     */
    public function registerPerson($regtypeid, array $user) {
        $regtype = $this->modx->getObject('RSVPMeRegType', array('id' => $regtypeid));
        if (!$regtype) return false;
        $event = $regtype->getOne('Event');
        $this->modx->log(modX::LOG_LEVEL_INFO,'[RSVPMe] Retrieved Event: ' . print_r($event->toArray(),true));

        $registered = $this->modx->newObject('RSVPMeRegistered');
        $registered->fromArray($user);
        $event->addMany($registered,'Registered');
        return $event->save();
    }

    /**
     * Gets a Chunk and caches it; also falls back to file-based templates
     * for easier debugging.
     *
     * @access public
     * @param string $name The name of the Chunk
     * @param array $properties The properties for the Chunk
     * @return string The processed content of the Chunk
     */
    public function getChunk($name,array $properties = array()) {
        $chunk = null;
        if (!isset($this->chunks[$name])) {
            $chunk = $this->modx->getObject('modChunk',array('name' => $name),true);
            if (empty($chunk)) {
                $chunk = $this->_getTplChunk($name,$this->config['chunkSuffix']);
                if ($chunk == false) return false;
            }
            $this->chunks[$name] = $chunk->getContent();
        } else {
            $o = $this->chunks[$name];
            $chunk = $this->modx->newObject('modChunk');
            $chunk->setContent($o);
        }
        $chunk->setCacheable(false);
        return $chunk->process($properties);
    }
    /**
     * Returns a modChunk object from a template file.
     *
     * @access private
     * @param string $name The name of the Chunk. Will parse to name.chunk.tpl by default.
     * @param string $suffix The suffix to add to the chunk filename.
     * @return modChunk/boolean Returns the modChunk object if found, otherwise
     * false.
     */
    private function _getTplChunk($name,$suffix = '.chunk.tpl') {
        $chunk = false;
        $lname = $this->config['use_multibyte'] ? mb_strtolower($name,$this->config['encoding']) : strtolower($name);
        $f = $this->config['chunksPath'].$lname.$suffix;
        if (file_exists($f)) {
            $o = file_get_contents($f);
            $chunk = $this->modx->newObject('modChunk');
            $chunk->set('name',$name);
            $chunk->setContent($o);
        }
        return $chunk;
    }

    /**
     * Output the final output and wrap in the wrapper chunk. Optional, but
     * recommended for debugging as it outputs the execution time to the output.
     *
     * Also, it is good to output your sippet code with wrappers for easier
     * CSS isolation and styling.
     *
     * @access public
     * @param string $output The output to process
     * @return string The final wrapped output
     */
    public function output($output) {
        if ($this->debugTimer !== false) {
            $output .= "<br />\nExecution time: ".$this->endDebugTimer()."\n";
        }
        return $output;
    }

    /**
     * Starts the debug timer.
     *
     * @access protected
     * @return int The start time.
     */
    protected function startDebugTimer() {
        $mtime = microtime();
        $mtime = explode(' ',$mtime);
        $mtime = $mtime[1] + $mtime[0];
        $tstart = $mtime;
        $this->debugTimer = $tstart;
        return $this->debugTimer;
    }

    /**
     * Ends the debug timer and returns the total number of seconds script took
     * to run.
     *
     * @access protected
     * @return int The end total time to execute the script.
     */
    protected function endDebugTimer() {
        $mtime = microtime();
        $mtime = explode(' ',$mtime);
        $mtime = $mtime[1] + $mtime[0];
        $tend = $mtime;
        $totalTime = ($tend - $this->debugTimer);
        $totalTime = sprintf("%2.4f s", $totalTime);
        $this->debugTimer = false;
        return $totalTime;
    }
}
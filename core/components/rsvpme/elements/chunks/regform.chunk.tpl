<form action="[[~[[*id]]]]" method="post">
<input name="regtypeid" type="hidden" value="[[+regtypeid]]" />
<label>Your Name: <span>[[+rsvpme.error.regname]]</span></label>
<input name="regname:required" type="text" value="[[+rsvpme.regname]]" />
<label>Your Email: <span>[[+rsvpme.error.email]]</span></label>
<input name="email:required:email" type="text" value="[[+rsvpme.email]]" />
<input name="registerforevent" type="submit" value="Submit" />
</form>
jQuery(document).ready(function($) {
   if ($.autogrow)
      $('textarea.MessageBox').livequery(function() {
         $(this).autogrow();
      });

   $("a.EditMessage").click(function(event) {
      var elLink = this;
      var elMsgdiv = $(this).parent().next();

/* insecure, but if check for userid and unread is done, that's not an issue */      
      var MessageID = elMsgdiv.get(0).id.substr(8, 10);
      alert('MessageID = '  + MessageID + '.');

      elMsgdiv = $(elMsgdiv).find('.Message');
/*
   msgtext must be called by ajax request
   (where messageid = messageid
    and userid = userid -- security: otherwise attacker might view any message
    and message = unread -- comfort: stop user from senseless work as early as possible)
   security: userid must not be spoofable!!!! otherwise attacker could see any conversation message!!!!
 */      
      var msgtext = elMsgdiv.text().trim();
      var elInput = $("<textarea>", { val: msgtext,
         rows: "6",
         class: "MessageBox EditBox"
         });
      elMsgdiv.replaceWith(elInput);
      elInput.select();
      elLink.innerHTML = 'Save';

// rename "edit" to "save"
// check if message is still unread and also that userid is the same!
//    yes: save
//    no: echo error
// change textarea back to div, using the right formatter
      
      event.preventDefault();
      return false;
   });
});

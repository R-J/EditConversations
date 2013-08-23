jQuery(document).ready(function($) {
   if ($.autogrow)
      $('textarea.MessageBox').livequery(function() {
         $(this).autogrow();
      });

   $("a.EditMessage").click(function() {
       var input = $("<textarea>", { val: $(this).text(),
         cols: "100",
         rows: "6",
         class: "MessageBox",
         style: "overflow: hidden; display: block;"
         });
         
      /* replace not this, but the next Message */
      /* change "Edit" to "Save" or create New button or even create save button in plugin but hide it with css and show only now? */
      $(this).replaceWith(input);
      input.select();
   });
});

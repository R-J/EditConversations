<?php if (!defined('APPLICATION')) exit();

$PluginInfo['EditConversations'] = array(
   'Name' => 'Edit Conversations',
	'Description'	=> 'Allows editing of unread conversation messages',
	'Version' => '0.1',
	'Author' => 'R_J',
   'RequiredApplications' => array('Vanilla' => '>=2.0.18', 'Conversations' => '>=2.0.18'),
   'License' => 'GPLv2'
);

class EditConversationsPlugin extends Gdn_Plugin
{	
   /*
   // not used
   public function Setup()	{
   }

   public function OnDisable() {
   }
   */
   
   // add some css
   public function MessagesController_Render_Before($Sender) {
      $Sender->AddCssFile($this->GetResource('design/custom.css', FALSE, FALSE));
      $Sender->AddJsFile($this->GetResource('js/edit.js', FALSE, FALSE));
   }
   
   // change Get-query so that info of last viewed message is enclosed
   public function ConversationMessageModel_BeforeGet_Handler($Sender) {
      $Sender->SQL->Select('uc2.DateLastViewed', 'max', 'DateLastViewed')
         ->From('UserConversation uc2')
         ->Where('c.ConversationID', 'uc2.ConversationID', FALSE, FALSE)
         ->Where('uc2.UserID <>', Gdn::Session()->UserID)
         ->GroupBy('cm.MessageID');
   }

   // add read/unread css and edit button
   public function MessagesController_BeforeConversationMessageItem_Handler($Sender) {
      $Message = $Sender->EventArguments['Message'];
      if ($Message->DateLastViewed < $Message->DateInserted) {
         $Sender->EventArguments['Class'] .= ' MessageUnread ';
         echo Wrap(Anchor(T('Edit'), '#', 'Button SmallButton EditMessage')
            , 'li'
            , array('class' => 'EditMessageContainer')
         );
      } else {
         $Sender->EventArguments['Class'] .= ' MessageRead ';
      }
   }

   public function MessagesController_BeforeConversationMessageBody_Handler($Sender) {
 
   }

   public function MessagesController_Edit_Create($Sender) {
   // http://stackoverflow.com/questions/6814062/using-javascript-to-change-some-text-into-an-input-field-when-clicked-on
      // echo $Sender->RequestArgs[0];
      // GetID($Sender->RequestArgs[0]), if UserID <> Gdn::Session()->UserID echo "no permission!", return

   }
}

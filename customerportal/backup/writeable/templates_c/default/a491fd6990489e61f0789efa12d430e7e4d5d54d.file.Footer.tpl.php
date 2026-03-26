<?php /* Smarty version Smarty-3.1.19, created on 2022-06-11 08:37:13
         compiled from "C:\xampp\htdocs\bemlanother\customerportal\layouts\default\templates\Footer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:133726686762a43819bc2607-65027611%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a491fd6990489e61f0789efa12d430e7e4d5d54d' => 
    array (
      0 => 'C:\\xampp\\htdocs\\bemlanother\\customerportal\\layouts\\default\\templates\\Footer.tpl',
      1 => 1651513020,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '133726686762a43819bc2607-65027611',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_62a43819c15898_50201605',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62a43819c15898_50201605')) {function content_62a43819c15898_50201605($_smarty_tpl) {?>
<script>
    (function (w, d) {
        w.CollectId = "620f6759615a07609d71c99f";
        var h = d.head || d.getElementsByTagName("head")[0];
        var s = d.createElement("script");
        s.setAttribute("type", "text/javascript");
        s.setAttribute("src", "https://3.7.71.53/beml/launcher.js");
        s.async = true;
        h.appendChild(s);
    })(window, document);

    var collectchat = window.collectchat || {};
    collectchat.ready = function () {
        collectchat.on('complete', function (list) {
            let e = {};
            e['data'] = list;
            let equipmentType = list[2]['answer'];
            let priority = list[3]['answer'];
            let EquipmentId = list[4]['answer'];
            let issueDescription = list[5]['answer'];
            let remarks = list[6]['answer'];
            let location = list[7]['answer'];
           
            let query = '?ticket_title='+remarks+'&cf_1065='+location+'&cf_1063='+issueDescription+'&cf_1061='+EquipmentId+'&publicid=158b030b274f5da5bf3ddb895eec0ae6'+'&ticketpriorities='+priority+'&cf_1059='+equipmentType+'&ticketstatus=Open&parent_id=11x7774&contact_id=12x8035';
            let http = window.XMLHttpRequest ? new XMLHttpRequest : new ActiveXObject("Microsoft.XMLHTTP");
            let res = '';
            http.open("POST", "https://3.7.71.53/beml/modules/Webforms/capture.php"+query);

            http.onreadystatechange = function () {
                if (http.readyState == 4 && http.status == 200) {
                }
            } 
            http.send(res);
        });
    }
</script>
</div>
</body>
</html>
<?php }} ?>

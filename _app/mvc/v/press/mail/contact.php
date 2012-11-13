<html>
<head>
    <title>Contact</title>
</head>
<body>
<table cellspacing="0" cellpadding="0" border="0" width="100%" style="margin:0;" bgcolor="#900" background="<?=Site::url("pub")?>/app/press/img/territoire.jpg">
    <tr>
        <td width="100%" height="16px">
        </td>
    </tr>
    <tr>
        <td>
            <table cellspacing="0" cellpadding="0" border="0" width="620px" style="margin:0 auto;" bgcolor="#ffffff">
                <tr>
                    <td height="16px">
                    </td>
                </tr>
                <tr>
                    <td width="16px">
                    </td>
                    <td width="588px" bgcolor="#ffffff" style="font-family:Arial, sans-serif; font-size:12px; line-height:13px; color:#000000;">

                        <b><?=$data['senderemail'] ?></b> <?=$tr('shared_link_with_you') ?> <a href="<?=Site::$host?>"><font color="#990000"><u><?= $domain ?></u></font></a>

                    </td>
                    <td width="16px">
                    </td>
                </tr>
                <tr>
                    <td height="16px">
                    </td>
                </tr>

                <? /* message de l'ami */ ?>

                <tr>
                    <td width="16px">
                    </td>
                    <td width="588px" bgcolor="#ffffff" style="font-family:Arial, sans-serif; font-size:12px; line-height:13px; color:#000000;">
                        <?=$data['message'] ?>
                    </td>
                    <td width="16px">
                    </td>
                </tr>
                <tr>
                    <td height="16px">
                    </td>
                </tr>

                <? /* fin message de l'ami */ ?>
                <tr>
                    <td width="16px">
                    </td>
                    <td>
                        <table cellspacing="0" cellpadding="0" border="0" width="588px" style="margin:0 auto;" bgcolor="#ffffff">
                            <tr>
                                <td width="100px" height="100px" bgcolor="#ffffff" style="font-family:Arial, sans-serif; font-size:12px; line-height:13px; color:#000000;" valign="top">
                                    <a href="<?=$this->url($theItem,true ); ?>"><img src="<?=$rootUrl."/".ImageTools::sized($theItem->smallPicture->name,
                                        100,
                                        100,
                                        "noBorder",
                                        "jpg",
                                        "ffffff",
                                        0) ?>"
                                                                                     alt="<?=$theItem->trads->title ?>" alt="<?=$theItem->trads->title ?>" width="100px" height="100px" border="0"/></a>
                                </td>
                                <td width="16px" height="100px">
                                </td>
                                <td valign="top">
                                    <table cellspacing="0" cellpadding="0" border="0" width="472px" style="margin:0 auto;" bgcolor="#ffffff">
                                        <tr>
                                            <td width="472px" bgcolor="#ffffff" style="font-family:Arial, sans-serif; font-size:13px; line-height:13px; color:#990000;" valign="top">
                                                <b><a href="<?=$this->url($theItem,true ); ?>"><font color="#990000"><?=$theItem->trads->title ?></font></a></b>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="472px" height="5px">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="472px" bgcolor="#ffffff" style="font-family:Arial, sans-serif; font-size:11px; line-height:13px; color:#aaaaaa;" valign="top">
                                                <a href="<?=$this->url($theItem,true ); ?>"><font color="#aaaaaa"><u><?=$this->url($theItem,true ); ?></u></font></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="472px" height="5px">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="472px" bgcolor="#ffffff" style="font-family:Arial, sans-serif; font-size:12px; line-height:13px; color:#000000;" valign="top">
                                                <?=$theItem->trads->baseline ?>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td width="16px">
                    </td>
                </tr>
                <tr>
                    <td height="16px">
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td width="100%" height="16px">
        </td>
    </tr>
</table>
</body>
</html>

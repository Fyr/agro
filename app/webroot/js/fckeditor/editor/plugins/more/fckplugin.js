/*
 * File Authors: Ratibor
 */

var My_FCKmoreCommand = function()
{

}

My_FCKmoreCommand.prototype.Execute = function()
{
    FCK.InsertHtml('&lt;--more--&gt;');
}

My_FCKmoreCommand.prototype.GetState = function()
{
    return FCK_TRISTATE_OFF; 
}

// Register the related command.
FCKCommands.RegisterCommand('more', new My_FCKmoreCommand());

// Create the "more" toolbar button.
var moreItem = new FCKToolbarButton("more", FCKLang.moreButton);
moreItem.IconPath = FCKConfig.PluginsPath + 'more/more.gif';

// 'more' is the name used in the Toolbar config.
FCKToolbarItems.RegisterItem('more', moreItem);
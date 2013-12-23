/*
 * For FCKeditor 2.6
 * 
 * File Name: fckplugin.js
 * 	Add a toolbar button to resizeEditor.
 * 
 * File Authors:
 * 		lurocky
 */
var EditingAreaFrameHeights = new Object() ;
EditingAreaFrameHeights.GetHeight = new Object() ;
EditingAreaFrameHeights.getdefaultHeight = function(eEditorFrame)
{
	var height = EditingAreaFrameHeights.GetHeight[eEditorFrame.id] ;
	if ( height )
		return height ;
	height = parseInt(eEditorFrame.style.height ) ;
	EditingAreaFrameHeights.GetHeight[eEditorFrame.id] = height ;
	return height ;
}
 
var LasizeEditorCommand = function (commandName) {
  this.Name = commandName;
  this.MaxHeight = 1000 ;
  this.LargerSize = 100 ;
};
LasizeEditorCommand.prototype.Execute = function () {
	var eEditorFrame = window.frameElement ;
	var eEditorFrameStyle	= eEditorFrame.style ;
	var EditingAreaOffsetHeight = parseInt( FCK.EditingArea.IFrame.offsetHeight ) ;
	var height = parseInt(eEditorFrameStyle.height ) ;
	var defaultHeight = EditingAreaFrameHeights.getdefaultHeight(eEditorFrame) ;
	var mHeight = this.MaxHeight < defaultHeight ? defaultHeight : this.MaxHeight
	if ((height + this.LargerSize) > mHeight)
	{
		return ;
	}
	else
	{
		if ( FCKBrowserInfo.IsOpera) {
			var EditingAreaOffsetHeight = 0;
			if ( FCK.EditingArea.Mode == FCK_EDITMODE_WYSIWYG ) {
				EditingAreaOffsetHeight = parseInt( FCK.EditingArea.IFrame.offsetHeight ) ;
				EditingAreaOffsetHeight += this.LargerSize ;
				EditingAreaOffsetHeight += 'px' ;
				FCK.EditingArea.IFrame.style.height = EditingAreaOffsetHeight ;
			}
			else {
				EditingAreaOffsetHeight = parseInt( FCK.EditingArea.Textarea.offsetHeight ) ;
				EditingAreaOffsetHeight += this.LargerSize ;
				EditingAreaOffsetHeight += 'px' ;
				FCK.EditingArea.Textarea.style.height = FCK.EditingArea.Textarea.style.height ;
			}
		}
		height += this.LargerSize ;
		height += 'px' ;
		eEditorFrameStyle.height = height ;
		ResizeEditorRefreshState();
	}
};
LasizeEditorCommand.prototype.GetState = function () {
	var eEditorFrame = window.frameElement ;
	var eEditorFrameStyle	= eEditorFrame.style ;
	var height = parseInt(eEditorFrameStyle.height ) ;
	var defaultHeight = EditingAreaFrameHeights.getdefaultHeight(eEditorFrame) ;
	var mHeight = this.MaxHeight < defaultHeight ? defaultHeight : this.MaxHeight
	if ((height + this.LargerSize) > mHeight || FCK.Commands.GetCommand('FitWindow').GetState() == FCK_TRISTATE_ON)
		return FCK_TRISTATE_DISABLED;
  return ( height > defaultHeight ? FCK_TRISTATE_ON : FCK_TRISTATE_OFF );
};

// Register the related commands.
FCKCommands.RegisterCommand("LargerSizeEditor", new LasizeEditorCommand(FCKLang["LargerEditorWindow"]));

// Create the "LargerSizeEditor" toolbar button.
var LargerSizeEditorItem = new FCKToolbarButton("LargerSizeEditor", FCKLang["LargerEditorWindow"], null, null, true, true, FCKConfig.PluginsPath + "resizeeditor/largersize.gif");
FCKToolbarItems.RegisterItem("LargerSizeEditor", LargerSizeEditorItem);     // 'LargerSizeEditor' is the name used in the Toolbar config.

var NasizeEditorCommand = function (commandName) {
  this.Name = commandName;
  this.MinHeight = 200 ;
  this.NarrowSize = 100 ;
};
NasizeEditorCommand.prototype.Execute = function () {
	var eEditorFrame = window.frameElement ;
	var eEditorFrameStyle	= eEditorFrame.style ;
	var height = parseInt(eEditorFrameStyle.height ) ;
	var defaultHeight = EditingAreaFrameHeights.getdefaultHeight(eEditorFrame) ;
	var mHeight = (this.MinHeight > defaultHeight) ? defaultHeight : this.MinHeight ;
	if ((height - this.NarrowSize) < mHeight) {
		return ;
	}
	else {
		if ( FCKBrowserInfo.IsOpera) {
			var EditingAreaOffsetHeight = 0;
			if ( FCK.EditingArea.Mode == FCK_EDITMODE_WYSIWYG ) {
				EditingAreaOffsetHeight = parseInt( FCK.EditingArea.IFrame.offsetHeight ) ;
				EditingAreaOffsetHeight -= this.NarrowSize ;
				EditingAreaOffsetHeight += 'px' ;
				FCK.EditingArea.IFrame.style.height = EditingAreaOffsetHeight ;
			}
			else {
				EditingAreaOffsetHeight = parseInt( FCK.EditingArea.Textarea.offsetHeight ) ;
				EditingAreaOffsetHeight -= this.NarrowSize ;
				EditingAreaOffsetHeight += 'px' ;
				FCK.EditingArea.Textarea.style.height = FCK.EditingArea.Textarea.style.height ;
			}
		}
		height -= this.NarrowSize ;  
		height += 'px' ;
		eEditorFrameStyle.height = height ;
		ResizeEditorRefreshState();
	}
};
NasizeEditorCommand.prototype.GetState = function () {
	var eEditorFrame = window.frameElement ;
	var eEditorFrameStyle	= eEditorFrame.style ;
	var height = parseInt(eEditorFrameStyle.height ) ;
	var defaultHeight = EditingAreaFrameHeights.getdefaultHeight(eEditorFrame) ;
	var mHeight = (this.MinHeight > defaultHeight) ? defaultHeight : this.MinHeight
	if ((height - this.NarrowSize) < mHeight || FCK.Commands.GetCommand('FitWindow').GetState() == FCK_TRISTATE_ON)
		return FCK_TRISTATE_DISABLED;
  return ( height < defaultHeight ? FCK_TRISTATE_ON : FCK_TRISTATE_OFF );;
};

// Register the related commands.
FCKCommands.RegisterCommand("NarrowSizeEditor", new NasizeEditorCommand(FCKLang["NarrowEditorWindow"]));

// Create the "NarrowSizeEditor" toolbar button.
var NarrowSizeEditorItem = new FCKToolbarButton("NarrowSizeEditor", FCKLang["NarrowEditorWindow"], null, null, true, true, FCKConfig.PluginsPath + "resizeeditor/narrowsize.gif");
FCKToolbarItems.RegisterItem("NarrowSizeEditor", NarrowSizeEditorItem);     // 'NarrowSizeEditor' is the name used in the Toolbar config.

var ResetsizeEditorCommand = function (commandName) {
  this.Name = commandName;
};
ResetsizeEditorCommand.prototype.Execute = function () {
	var eEditorFrame = window.frameElement ;
	var eEditorFrameStyle	= eEditorFrame.style ;
	var height = EditingAreaFrameHeights.getdefaultHeight(eEditorFrame) ;
	if (height == parseInt( eEditorFrameStyle.height )) {
		return ;
	}
	else {
		if ( FCKBrowserInfo.IsOpera) {
			var EditingAreaOffsetHeight = 0;
			if ( FCK.EditingArea.Mode == FCK_EDITMODE_WYSIWYG ) {
				EditingAreaOffsetHeight = parseInt( FCK.EditingArea.IFrame.offsetHeight ) ;
				EditingAreaOffsetHeight += height - parseInt( eEditorFrameStyle.height ) ;
				EditingAreaOffsetHeight += 'px' ;
				FCK.EditingArea.IFrame.style.height = EditingAreaOffsetHeight ;
			}
			else {
				EditingAreaOffsetHeight = parseInt( FCK.EditingArea.Textarea.offsetHeight ) ;
				EditingAreaOffsetHeight += height - parseInt( eEditorFrameStyle.height ) ;
				EditingAreaOffsetHeight += 'px' ;
				FCK.EditingArea.Textarea.style.height = EditingAreaOffsetHeight ;
			}
		}
		height += 'px' ;
		eEditorFrameStyle.height = height ;
		ResizeEditorRefreshState();
	}
};
ResetsizeEditorCommand.prototype.GetState = function () {
	var eEditorFrame = window.frameElement ;
	var eEditorFrameStyle	= eEditorFrame.style ;
	var height = parseInt(eEditorFrameStyle.height ) ;
	var defaultHeight = EditingAreaFrameHeights.getdefaultHeight(eEditorFrame) ;
	if (height == defaultHeight || FCK.Commands.GetCommand('FitWindow').GetState() == FCK_TRISTATE_ON)
		return FCK_TRISTATE_DISABLED;
  return FCK_TRISTATE_OFF;
};

// Register the related commands.
FCKCommands.RegisterCommand("ResetSizeEditor", new ResetsizeEditorCommand(FCKLang["ResetEditorWindow"]));

// Create the "ResetSizeEditor" toolbar button.
var ResetSizeEditorItem = new FCKToolbarButton("ResetSizeEditor", FCKLang["ResetEditorWindow"], null, null, true, true, FCKConfig.PluginsPath + "resizeeditor/reset.gif");
FCKToolbarItems.RegisterItem("ResetSizeEditor", ResetSizeEditorItem);     // 'ResetSizeEditor' is the name used in the Toolbar config.

var ResizeEditorRefreshState = function (editorInstance) {
	var oToolbarset = (editorInstance) ? editorInstance.ToolbarSet : FCK.ToolbarSet;
	oToolbarset.ToolbarItems.GetItem('LargerSizeEditor').RefreshState() ;
	oToolbarset.ToolbarItems.GetItem('NarrowSizeEditor').RefreshState() ;
	oToolbarset.ToolbarItems.GetItem('ResetSizeEditor').RefreshState() ;
};
var FCKDefaultFocus = FCK.Focus;
if (FCKConfig.ToolbarLocation != 'In' && FCKConfig.ToolbarLocation != 'None') {
	FCK.Events.AttachEvent( 'OnBlur', ResizeEditorRefreshState ) ;
	FCK.Events.AttachEvent( 'OnFocus', ResizeEditorRefreshState ) ;
} else if (FCKConfig.ToolbarLocation == 'In') {
	FCK.Focus = function() {
		FCKDefaultFocus();
		ResizeEditorRefreshState();
	};
}

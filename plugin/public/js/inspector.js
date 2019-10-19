'use strict';

var el = wp.element.createElement;
var SgddInspector = function( attributes ) {
	this.block = attributes.block;
};

SgddInspector.prototype = Object.create( wp.element.Component.prototype );
SgddInspector.prototype.render = function() {
	return [
		el( wp.components.PanelBody, { title: 'File embed options', className: 'sgdd-block-settings' }, [
			el( SgddIntegerSetting, {block: this.block, name: 'embedWidth'}),
			el( SgddIntegerSetting, {block: this.block, name: 'embedHeight'})
		]),
		el( wp.components.PanelBody, { title: 'Folder embed options', className: 'sgdd-block-settings' }, [
			el( SgddIntegerSetting, {block: this.block, name: 'listWidth'}),
			el( SgddIntegerSetting, {block: this.block, name: 'gridCols'}),
			el( SgddSelectSetting, {block: this.block, name: 'folderType'}),
			el( SgddButtonSetting, {block: this.block, name: 'setPermissions'})
		])
	];
};

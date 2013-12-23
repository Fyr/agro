$(document).ready(function() {
// begin ----------------------------------------


// menu

$( '.menu' ).children('.l').children('.r').children('ul').children( 'li' ).children( 'a' ).mouseover( function(){
	$( this ).addClass( 'sel' );
} );
$( '.menu' ).children('.l').children('.r').children('ul').children( 'li' ).mouseover( function(){
	$( this ).find( 'ul' ).fadeIn( 200 );
} );
$( '.menu' ).children('.l').children('.r').children('ul').children( 'li' ).mouseleave( function(){
	$( this ).find( 'a' ).removeClass( 'sel' );
	$( this ).find( 'ul' ).fadeOut( 200 );
} );


// carousel

var container = jQuery('#slider .logos-move');
var mover = container.find('.mover');
var left = 0;
var direc = 'l';
var speed = 1;
var stop_at_end = false;
var view_width = container.width();
var imgs_width = container.find('.mover-in').width();

setInterval ( move_imgs, 30 );

function move_imgs(){
	if( direc == 'r' ){
		if( left >= 100 ){
			left = 100;
			direc = 'l';
			if(stop_at_end) speed = 0;
		} else {
			left += speed;
			mover.css( 'left' , left+'px' );
		}
	} else {
		if( left <= - imgs_width + view_width - 100 ){
			left = - imgs_width + view_width - 100;
			direc = 'r';
			if(stop_at_end) speed = 0;
		} else {
			left -= speed;
			mover.css( 'left' , left+'px' );
		}
	}
}

//container.find( '.left' ).mouseenter( function(){ direc = 'l' } );
//container.find( '.right' ).mouseenter( function(){ direc = 'r' } );

var wra = jQuery('#slider.logos-move-wrapper');

wra.find( '.arrow-left' ).mousedown( function(){
	stop_at_end = true;
	direc = 'l';
	speed = 5;
} );
wra.find( '.arrow-left' ).mouseup( function(){
	speed = 1;
	direc = 'l';
	stop_at_end = false;
} );
wra.find( '.arrow-left' ).mouseleave( function(){
	speed = 1;
	stop_at_end = false;
} );

wra.find( '.arrow-right' ).mousedown( function(){
	direc = 'r';
	stop_at_end = true;
	speed = 5;
} );
wra.find( '.arrow-right' ).mouseup( function(){
	direc = 'r';
	speed = 1;
	stop_at_end = false;
} );
wra.find( '.arrow-right' ).mouseleave( function(){
	speed = 1;
	stop_at_end = false;
} );



// end all --------------------------------------
// }
$('img[align=left]').css('margin', '10px 10px 10px 0px');
$('img[align=right]').css('margin', '10px 0px 10px 10px');

});
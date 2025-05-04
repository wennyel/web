(function() {
"use strict"

function qs( q ) {
	return document.querySelector( q );
}
function qsa( q ) {
	return document.querySelectorAll( q );
}
var zIndex = 1000;
var mobile;
var freezeScrollPos;

function modal( elem, focus ) 
{
	if( !elem ) {
		return this;
	}

	mobile = false;
	window.onkeydown = function(e) {
		if(e.keyCode == 27) this.close();
	}.bind(this);

	window.addEventListener('resize', this.resize);

	var overlay = document.createElement('div');
	overlay.className = 'modalx-overlay close_mw',
	overlay.style.zIndex = zIndex,
	document.body.insertBefore(overlay, document.body.childNodes[0]);

	var win = qs( elem ).cloneNode( true );
	overlay.appendChild( win );
	win.style.display = 'block';
	win.style.zIndex = zIndex+1;
	var top = (window.innerHeight / 2) - (win.offsetHeight / 2);

	if( !mobile ) {
		win.style.top = (top < 20 ? 20 : top) + 'px';
	}

	// отображаем окно и фон
	overlay.style.visibility = 'visible';
	overlay.style.background = 'rgba(14, 12, 13, 0.8)';
	win.style.visibility = 'visible';
	win.style.transform =  'scale(1)';
	
	this.close = this.close.bind(this);
	var cl = qsa('.close_mw');
	for(var i=0; i<cl.length; ++i ) {
		cl[i].addEventListener('click', this.close);
	}

	if(document.body.scrollHeight - document.body.offsetHeight <= 0) {
		document.body.style.marginRight = scrollbarWidth() + 'px';
	}
	document.body.style.overflow = 'hidden';
	freezeScrollPos = $('html, body').scrollTop();
	window.addEventListener('scroll', freezeScroll);

	if( focus ) {
		setTimeout(function() {
			win.querySelector( focus ).focus();
		}, 200);
	}
	zIndex += 2;
	return false;
}
modal.arrows = modal.prototype.arrows = function(prev, next) {
	var w = qs('.modalx-overlay');
	if( prev ) {
		if( !qs('#prev_arrow') ) {
			var p = document.createElement('a');
			p.id = 'prev_arrow';
			p.href = '#';
			p.onclick = prev;
			w.insertBefore(p, w.firstChild);
		} else {
			qs('#prev_arrow').onclick = prev;
		}
	} else if( qs('#prev_arrow') ) {
		qs('#prev_arrow').remove();
	}
	if( next ) {
		if( !qs('#next_arrow') ) {
			var n = document.createElement('a');
			n.id = 'next_arrow';
			n.href = '#';
			n.onclick = next;
			w.appendChild(n);
			var right = getComputedStyle(n).getPropertyValue('right');
			if(w.scrollHeight - w.offsetHeight > 0) {
				qs('#next_arrow').style.right = parseInt(right) + scrollbarWidth() + 'px';
			}
		} else {
			qs('#next_arrow').onclick = next;
		}
	} else if( qs('#next_arrow') ) {
		qs('#next_arrow').remove();
	}
}
modal.closeAll = modal.prototype.closeAll = function() {
	var windows = qsa('.modalx-overlay');
	for(var i=1; i<windows.length; ++i) {
		document.body.removeChild(windows[i]);
	}
	this.close();
	return false;
}
modal.close = modal.prototype.close = function( e )
{
	if( e !== undefined && e.target != e.currentTarget ) {
		return false;
	}

	if( e !== undefined ) {
		e.preventDefault();
	}
	window.onkeydown = null;
	var modals = qsa('.modalx-overlay').length;
	if( !modals ) {
		return;
	}
	var lastModal = qsa('.modalx-overlay')[0];
	var w = lastModal.querySelector(".modal_window");

	w.style.transform = 'scale(0)';
	w.style.opacity = 0;

	lastModal.addEventListener("transitionend", function (e) {
		if(e.target.className != lastModal.className) {
			return;
		}

		if( modals == 1 ) {
			window.removeEventListener('scroll', freezeScroll);
			document.body.style.overflow = 'auto';
			document.body.style.marginRight = 0;
		}
		if( e.target.parentNode ) {
			e.target.parentNode.removeChild(e.target);
		}
	})
	lastModal.style.background = 'rgba(0,0,0,0)';
	modal.afterClose( w.id );
	return false;
}
modal.afterClose = function(id) {}

modal.prototype.resize = function() 
{
	var overlay = qsa('.modalx-overlay');
	if( !overlay.length ) {
		return;
	}
	for( var i=0; i<overlay.length; ++i) {
		var win = overlay[i].querySelector('.modal_window');
		var top = (window.innerHeight / 2) - (win.offsetHeight / 2);
		win.style.top = (top < 20 ? 20 : top) + 'px';
	}
}

function scrollbarWidth() {
	var div = document.createElement('div');
	div.style.overflowY = 'scroll';
	div.style.width =  '50px';
	div.style.height = '50px';
	div.style.visibility = 'hidden';
	document.body.appendChild(div);
	var scrollWidth = div.offsetWidth - div.clientWidth;
	document.body.removeChild(div);
    return scrollWidth;
}
function freezeScroll() {
	$('html, body').scrollTop(freezeScrollPos);
}
window.modal = modal;
})();

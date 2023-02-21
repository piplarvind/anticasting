/*
var gallery = document.querySelector('.gallery-video');
var galleryItems = document.querySelectorAll('.gallery-item-video');
var numOfItems = gallery.children.length;
var itemWidth = 23; // percent: as set in css

var featured = document.querySelector('.featured-item-video');

//console.log(document.querySelector('.featured-item-video'));

var leftBtn = document.querySelector('.move-btn.left');
var rightBtn = document.querySelector('.move-btn.right');
var leftInterval;
var rightInterval;

var scrollRate = 0.2;
var left;

function selectItem(e) {
  
	if (e.target.classList.contains('active')) return;
	// console.log('e.target', e.target.style.backgroundImage);
    console.log('e.target' + img.src.match('undefined'));
 
	if (e.target.src == null ) {

		e.target.addEventListener("click", function() {
			$('#upload-video-modal').modal('show');
			$('#upload-video-modal').appendTo('body');
		});
	} else {
		featured.src = e.target.src;
		for (var i = 0; i < galleryItems.length; i++) {
			if (galleryItems[i].classList.contains('active'))
				galleryItems[i].classList.remove('active');
		}
		e.target.classList.add('active');
	}	
}

function galleryWrapLeft() {
	var first = gallery.children[0];
	gallery.removeChild(first);
	gallery.src.left = -itemWidth + '%';
	gallery.appendChild(first);
	gallery.src.left = '0%';
}

function galleryWrapRight() {
	var last = gallery.children[gallery.children.length - 1];
	gallery.removeChild(last);
	gallery.insertBefore(last, gallery.children[0]);
	gallery.src.left = '-23%';
}

function moveLeft() {
	left = left || 0;

	leftInterval = setInterval(function() {
		gallery.src.left = left + '%';

		if (left > -itemWidth) {
			left -= scrollRate;
		} else {
			left = 0;
			galleryWrapLeft();
		}
	}, 1);
}

function moveRight() {
	//Make sure there is element to the leftd
	if (left > -itemWidth && left < 0) {
		left = left  - itemWidth;
		
		var last = gallery.children[gallery.children.length - 1];
		gallery.removeChild(last);
		gallery.src.left = left + '%';
		gallery.insertBefore(last, gallery.children[0]);	
	}
	
	left = left || 0;

	leftInterval = setInterval(function() {
		gallery.src.left = left + '%';

		if (left < 0) {
			left += scrollRate;
		} else {
			left = -itemWidth;
			galleryWrapRight();
		}
	}, 1);
}

function stopMovement() {
	clearInterval(leftInterval);
	clearInterval(rightInterval);
}

// leftBtn.addEventListener('mouseenter', moveLeft);
// leftBtn.addEventListener('mouseleave', stopMovement);
// rightBtn.addEventListener('mouseenter', moveRight);
// rightBtn.addEventListener('mouseleave', stopMovement);


//Start this baby up
(function init() {
	// $("#upload-image-modal").modal('show');
	var urls = [
		'https://www.youtube.com/embed/5XWfavgmZoQ',
		'https://www.youtube.com/embed/4ALbrJVt1u4'


	];
	//Set Initial Featured Image
	featured.src =  urls[0];
	
	//Set Images for Gallery and Add Event Listeners
	for (var i = 0; i < galleryItems.length; i++) {
		galleryItems[i].src = urls[i];
        
		galleryItems[i].addEventListener('click', selectItem);
		
		// galleryItems[i].addEventListener('click', function() {
		// 	if (images[i] === undefined) {
		// 		console.log('images[i]', images[i]);
		// 		$('#upload-image-modal').modal('show');
		// 		$('#upload-image-modal').appendTo('body');
		// 	} else {
		// 		galleryItems[i].addEventListener('click', selectItem);
		// 	}
		// });
		galleryItems[i].addEventListener('mouseover', selectItem);
	}
})();
*/
var myModal = document.getElementById('upload-video-modal');
document.onreadystatechange = function() {
    
    myModal.show();
}
$('.popup').on('click',function(){
	// alert($(this).attr('data-src'));
	$('#work_reel').attr('name', $(this).attr('id'));
	$('#work_reel').attr('value', $(this).attr('data-src'));
	$('#upload-video-modal').modal('show');
	$('#upload-video-modal').appendTo('body');
});

// Popover Sample Video
$('#sampleVideo').on('click',function(){
	$('#sampleVideoModal').modal('show');
	$('#sampleVideoModal').appendTo('body');
});
const list = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
list.map((el) => {
  let opts = {
    animation: false,
  }
  if (el.hasAttribute('data-bs-content-id')) {
    opts.content = document.getElementById(el.getAttribute('data-bs-content-id')).innerHTML;
    opts.html = true;
  }
  new bootstrap.Popover(el, opts);
})
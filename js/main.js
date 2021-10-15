$(document).ready(function() {
    var myFullpage = new fullpage('#fullpage', {
        licenseKey: 'E8FD0D97-057B474C-9619F2A3-CBCBBFC1 ',
        anchors: ['section1', 'section2', 'section3', 'section4', 'section5', 'section6', 'section7'],
        menu: '#menu',
        scrollBar: false,
        keyboardScrolling: true,
        verticalCentered: false,
        loopHorizontal: true,
        css3: true,
        onLeave: function(){
            jQuery('.section [data-aos]').removeClass("aos-animate");
        },
        onSlideLeave: function(){
            jQuery('.slide [data-aos]').removeClass("aos-animate");
        },
        afterSlideLoad: function(){
            jQuery('.slide.active [data-aos]').addClass("aos-animate");
        },
        afterLoad: function(){
            jQuery('.section.active [data-aos]').addClass("aos-animate");
        }
    
    });
    
    AOS.init({
        mirror: true
    });
});


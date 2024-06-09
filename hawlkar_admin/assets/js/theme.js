function cementUIChanges(key, value) {
    let settings = JSON.parse(localStorage.getItem('settings'));
    if(!settings) settings = {}
    settings[key] = value;
    localStorage.setItem('settings', JSON.stringify(settings));
}

$(document).ready(function() {
    (function () {
        
        $('.sidebar-menu-toggler').on('click', (e) => {
            let sidebarState = 'minified';
            if(!$('.app-sidebar.sidebar').is(":visible")) {
                $('.app-sidebar.sidebar').removeClass('minified')
                $('.app-sidebar.sidebar').show(300)
                // $('.sidebar-overlay').show('slide', {direcetion: 'left'},300)
                $('.sidebar-overlay').slideLeftShow(300);
                $(e.target).addClass('hide-toggle')
            } else if($(e.target).hasClass('hide-toggle')) {
                $('.app-sidebar.sidebar').hide(300)
                $('.sidebar-overlay').slideLeftHide(300)
            } else {
                if($('.app-sidebar.sidebar').hasClass('minified')) sidebarState = '';
                $('.app-sidebar.sidebar').toggleClass('minified', 20)
                cementUIChanges("sidebar", sidebarState);
            }
        })
    
        let settings = JSON.parse(localStorage.getItem('settings'));
        // console.log(settings)
        if(settings) {
            $('body').addClass(settings.theme);
            if(settings.sidebarSize) {
                $('.sidebar').removeClass('medium small large')
                $('.sidebar').addClass(settings.sidebarSize);
            }
            $('.sidebar').addClass(settings.sidebar);
        }

        if($('body').hasClass('dark')) {
            $('i.darkmode-toggler').removeClass('bi-moon')
            $('i.darkmode-toggler').addClass('bi-brightness-high')
        }
    })();

    setTimeout(() => {
        $('.loading-page').hide();
    }, 150)


    $('.dd-toggler').on('click', (e) => {
        e.stopPropagation()
        let target = $(e.currentTarget).data('target-dd')
        $('.app-header-dd').hide(0)
        $(`#${target}`).show(0);

        console.log(target)
    })

    $(document).on('click', () => {
        $('.app-header-dd').hide(0)
    })

    // Dark-mode toggle
    $('.toggle-system-color').on('click', (e) => {
        let color = $(e.currentTarget).data('color');
        if($('body').hasClass(color)) {
            $('body').removeClass(color);
            cementUIChanges('theme', 'none');
            $('i.darkmode-toggler').addClass('bi-moon')
            $('i.darkmode-toggler').removeClass('bi-brightness-high')
        } else {
            $('body').addClass(color);
            cementUIChanges('theme', color);
            $('i.darkmode-toggler').removeClass('bi-moon')
            $('i.darkmode-toggler').addClass('bi-brightness-high')
        }   
    })
    
});

jQuery.fn.extend({
    slideRightShow: function(time) {
      return this.each(function() {
          $(this).show('slide', {direction: 'right'}, time);
      });
    },
    slideLeftHide: function(time) {
      return this.each(function() {
        $(this).hide('slide', {direction: 'left'}, time);
      });
    },
    slideRightHide: function(time) {
      return this.each(function() {
        $(this).hide('slide', {direction: 'right'}, time);
      });
    },
    slideLeftShow: function(time) {
      return this.each(function() {
        $(this).show('slide', {direction: 'left'}, time);
      });
    }
  });
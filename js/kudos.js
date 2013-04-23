var Kudoable,
__bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; };

Kudoable = (function() {

  function Kudoable(element) {
    this.element = element;
    this.unkudo = __bind(this.unkudo, this);

    this.complete = __bind(this.complete, this);

    this.end = __bind(this.end, this);

    this.start = __bind(this.start, this);

    this.bindEvents();
    this.element.data('kudoable', this);
    this.meta = jQuery('.kudo-meta-'+this.element.attr('data-id'));
    this.element.data('kudoable', this);
  }

  Kudoable.prototype.bindEvents = function() {
    this.element.children('.kudo-object').mouseenter(this.start);
    this.element.children('.kudo-object').mouseleave(this.end);

    if (kudosdata.unkudo)
      this.element.children('.kudo-object').click(this.unkudo);
    else
      this.element.children('.kudo-object').css('cursor','default');

    jQuery(document).on('touchstart', this.element.children('.kudo-object'), this.start);
    return jQuery(document).on('touchend', this.element.children('.kudo-object'), this.end);
  };

  Kudoable.prototype.isKudoable = function() {
    return this.element.hasClass('kudoable');
  };

  Kudoable.prototype.isKudod = function() {
    return this.element.hasClass('kudo-complete');
  };

  Kudoable.prototype.start = function() {
    if (this.isKudoable() && !this.isKudod()) {
      this.element.trigger('kudo:active');
      this.element.addClass('kudo-active');

      this.meta.children('.kudo-hideonhover').hide();
      this.meta.children('.kudo-dontmove').show();

      return this.timer = setTimeout(this.complete, 700);
    }
  };

  Kudoable.prototype.end = function() {
    if (this.isKudoable() && !this.isKudod()) {
      this.element.trigger('kudo:inactive');
      this.element.removeClass('kudo-active');
      this.meta.children('.kudo-hideonhover').show();
      this.meta.children('.kudo-dontmove').hide();
      if (this.timer != null) {
        return clearTimeout(this.timer);
      }
    }
  };

  Kudoable.prototype.complete = function() {
    this.end();
    this.incrementCount();
    this.element.addClass('kudo-complete');
    return this.element.trigger('kudo:added');
  };

  Kudoable.prototype.unkudo = function(event) {
    event.preventDefault();
    if (this.isKudod()) {
      this.decrementCount();
      this.element.removeClass('kudo-complete');
      return this.element.trigger('kudo:removed');
    }
  };

  Kudoable.prototype.setCount = function(count) {
    return this.meta.find('.kudo-count:first').html(count);
  };

  Kudoable.prototype.currentCount = function() {
    return parseInt(this.meta.find('.kudo-count:first').html());
  };

  Kudoable.prototype.incrementCount = function() {
    return this.setCount(this.currentCount() + 1);
  };

  Kudoable.prototype.decrementCount = function() {
    var curCount = this.currentCount();
    if( curCount > 0 )
      return this.setCount(this.currentCount() - 1);
    else return curCount;
  };

  return Kudoable;

})();

jQuery(function($) {
  return $.fn.kudoable = function() {
    return this.each(function() {
      return new Kudoable($(this));
    });
  };
});


jQuery(document).ready(function($){

  /**
   * Used for saving a list of ids (each seperated by an underscore) in multiple
   * cookies if list is longer than 4000 bytes. This is important due to cookie
   * size restrictions.
   *
   * @param  {string} kudos list of post id's which have been kudo'd
   * @return {int}          number of created cookies
   */
  function koodiesave(kudos) { // read "cookiesave"
    if (kudos.length == 0){
      // remove koodies
      for(var i = 0; $.removeCookie('kudos'+i, { path: '/' }); i++);
      return 0;
    }else{
      // build array containing all our data, cookies have a max length of ~4096
      koodies = new Array();
      while(kudos.length > 4000){ // e.g. length 7634
        koodies.push( kudos.substr(kudos.length-4000) ); // 3635 is first elem
        kudos = kudos.substr(0,kudos.length-4000); // 3634 is last of next elem
      }
      koodies.push(kudos);

      // set cookies
      $.each( koodies, function(idx,val){
        $.cookie('kudos'+idx, val, { expires: parseInt(kudosdata.lifetime), path: '/' });
      });

      // remove cookies we do not longer need
      for(var i = koodies.length; $.removeCookie('kudos'+i, { path: '/' }); i++);

      // return number of created cookies
      return koodies.length;
    }
  }

  // initialize our kudo buttons
  $("figure.kudo").kudoable();

  // concatenate all cookie data in one string
  kudos = '';
  for(var i = 0; (koodie = $.cookie('kudos'+i)) !== undefined; i++)
    kudos += koodie;

  // mark already kudo'd items as kudo'd
  if (kudos.length > 0) {
    $("figure.kudo").each( function() {
      if (kudos.indexOf($(this).attr('data-id')+'_') > -1)
        $(this).removeClass("kudo-animate").addClass("kudo-complete");
    });
  }

  // kudo'd
  $("figure.kudo").bind("kudo:added", function(e){
    var id = $(this).attr('data-id');
    //console.log("Kudo'd", id); // for development

    // check if id of post has not already been kudo'd
    if (kudos.indexOf(id+'_') == -1) {
      // run ajax request to increment kudo counter on database
      $.post( kudosdata.ajaxurl,
        {
          action    : 'kudo',
          nonce     : kudosdata.nonce,
          id        : id
        },
        function(data) { // success callback

          // Legal nonce
          if(data.success) {
            kudos = kudos+id+'_';
            koodiesave(kudos);

            // Update kudo count with database value
            //$('.kudo-meta-'+id+' .kudo-count').html(data.count);
          }

          // Illegal nonce
          //if(!data.success)
          //  $(this).removeClass("kudo-complete").addClass("kudo-animate");
        }, "json"
      ).fail(function() { alert("failed"); }); // for development
    }
  });

  // unkudo'd
  $("figure.kudo").bind("kudo:removed", function(e){
    var id = $(this).attr('data-id');
    //console.log("Un-Kudo'd:", id); // for development

    // There are kudos
    if (kudos.length > 0) {
      nkudos = kudos.replace( new RegExp( id+'_', 'g' ), '' ); // remove id and separator

      if (kudos != nkudos) {
        $.post( kudosdata.ajaxurl,
          {
            action    : 'unkudo',
            nonce     : kudosdata.nonce,
            id        : id
          },
        function(data) { // success callback
          // Legal nonce
          if(data.success) {
            koodiesave(nkudos);
            kudos = nkudos;

            // Update kudo count with value retrieved from database
            //$('.kudo-meta-'+id+' .kudo-count').html(data.count);
          }

          // Illegal nonce
          //if(!data.success)
          //  $(this).removeClass("kudo-animate").addClass("kudo-complete");
        }, "json"
        ).fail(function() { alert("failed here"); });
      }
    }
  });

  if (parseInt(kudosdata.refresh) > 0) {
    $.ajaxSetup({ cache: false });
    var kudoables = new Array();
    $('.kudoable').each(function() {
      kudoables.push( $(this).attr('data-id') ); // 3635 is first elem
    });
    setInterval(function() {
      $.post( kudosdata.ajaxurl,
        {
          action    : 'kudocounts',
          nonce     : kudosdata.nonce,
          ids       : kudoables
        },
        function(data) { // success callback

          // Legal nonce
          if(data.success) {
            $.each(data.counts, function(idx, val) {
              $('.kudo-meta-'+idx+' .kudo-count').html(val);
            });
          }

        }, "json"
      );
    }, parseInt(kudosdata.refresh));
  }

});
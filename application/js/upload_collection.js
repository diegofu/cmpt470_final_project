$(document).ready(function() {
  var $exercises = new Array();
  var $collection_title;
  var $collection_description;

  Array.prototype.remove = function(from, to) {
    var rest = this.slice((to || from) + 1 || this.length);
    this.length = from < 0 ? this.length + from : from;
    return this.push.apply(this, rest);
  };

  $('a.ex_remove').live("click", function(event){
    event.preventDefault();
    var $exId = event.target.href.split(/#/)[1];
    for (var i = $exercises.length - 1; i >= 0; i--) {
      if ($exercises[i] == $exId) {
        $exercises.remove(i);
        $('a[href=#cart]').text('Cart' + '(' + $exercises.length + ')');
        break;
      };
    };
    $('a[href*="#' +  $exId + '"]').parent().parent().remove();
    // var $remove_id = event.target.

    // $remove_id = $('.ex_remove').parent().parent().children(':first-child');
    // $remove_id.parent().remove();
  });

  $('#exercises-container h3 a').live("click", function(event) {
    event.preventDefault();
    var $exId = event.target.href.split(/exercise\//)[1];
    // console.log(event.target.href.split(/exercise\//)[1]);
    var $info = $('a[href*="view_exercise/' +  $exId + '"]').parent().parent().parent().parent();
    // console.log($info);
    var $exLink = event.target.href;
    var $exTitle = $info.find('.title a').text();
    var $exAuthor = $info.find('a[href*="profiles/"]').text();
    var $exViews = $info.find("small:contains('Views')").parent().parent().find('.stat').text();
    var $exVotes = $info.find("small:contains('Ups')").parent().parent().find('.stat').text();
    var $exDate = $info.find("span:contains('Created by')").parent().find('span:last-child').text();
    // makesure its not already in array
    var $dupe = false;
    for(var i=0;i<$exercises.length;i++) {
      if ($exercises[i] == $exId) {
        $dupe = true;
      };
    }
    if (!$dupe) {
      $exercises.push($exId);
      //update cart
      $('a[href=#cart]').text('Cart' + '(' + $exercises.length + ')');
      $('.collection_exercises table tr:last').after(
        '<tr>' + 
        '<td>' + $exId + '</td>' + 
        '<td>' + $exTitle + '</td>' + 
        '<td>' + $exAuthor + '</td>' + 
        '<td>' + $exViews + '</td>' + 
        '<td>' + $exVotes + '</td>' + 
        '<td>' + $exDate + '</td>' + 
        '<td><a href="#' + $exId + '" class="ex_remove">Remove</a></td></tr>');
    };
  });

  function submit_collection() {
    /* get code from input: */
    $url = $('#base_url').val() + "collections/submit";
    /* Send the data using post and put the results in a div */
    $.post( $url, { name: $collection_title, description: $collection_description, exercises: $exercises },
      function( data ) {
          var content = $( data );
          $( "html" ).empty().append( content );
          // window.location.href = $('#base_url').val() + 'exercises/browse_exercises';
      }
    );
  };

  $('a.ue-next').click(function(event) {
    event.preventDefault();
    var active_tab = $('.nav-tabs .active');
    var active_pane = $('.tab-content .active');
    var href = $('.nav-tabs .active a').attr('href');
    var $next_tab = false;
    switch(href) {
      case '#title-desc':
        if ($('#inputDesc').val()!='') {
          destroyQtip($('#inputDesc'));
          $next_tab = true;
        } else {
          $next_tab = false;
          errorQtip('Please provide a description', $('#inputDesc'));
        }
        if ($('#inputTitle').val() != '') {
          destroyQtip($('#inputTitle'));
        } else {
          $next_tab = false;
          errorQtip('Please provide a title', $('#inputTitle'));
        }
        $('.ue-back').parent().removeClass('disabled');
        break;
      case '#add-exec':
        if ($exercises.length > 0) {
          $next_tab = true;
          destroyQtip($('a[href="#add-exec"]'));
          $('.ue-next').empty().append('Submit');
        } else {
          errorQtip('You need at least one exercise', $('a[href="#add-exec"]'));
        };
        fillSummary();
        break;
      case '#cart':
        $next_tab = true;
        if ($('#inputTitle').val() != '' || $('#inputDesc').val()!='') {
          destroyQtip($('a[href="#title-desc"]'));
        } else {
          $next_tab = false;
          errorQtip('Missing title or description', $('a[href="#title-desc"]'));
        }
        if ($exercises.length > 0) {
          $next_tab = true;
          destroyQtip($('a[href="#cart"]'));
          submit_collection();
        } else {
          errorQtip('You need at least one exercise', $('a[href="#cart"]'));
        };
        break;
    }
    if ($next_tab) { 
      active_tab.removeClass('active');
      active_pane.removeClass('active');
      active_tab.next().addClass('active');
      active_pane.next().addClass('active');
      $('.disabled.active').removeClass('disabled');
    };
  });
	$('a.ue-back').click(function(event) {
    event.preventDefault();
    destroyQtips();
    var active_tab = $('.nav-tabs .active');
    var active_pane = $('.tab-content .active');
    var href = $('.nav-tabs .active a').attr('href');
    active_tab.removeClass('active');
    active_pane.removeClass('active');
    active_tab.prev().addClass('active');
    active_pane.prev().addClass('active');
    switch(href) {
      case '#title-desc':
        break;
      case '#add-exec':
        $('.ue-back').parent().addClass('disabled');
        break;
      case '#cart':
        $('.ue-next').empty().append('Next');
        break;
    }
    $('.disabled.active').removeClass('disabled');
  });
  $('a[href$="#title-desc"]').click(function(event){
    event.preventDefault();
    $('.ue-next').empty().append('Next');
    $('.disabled.active').removeClass('disabled');
    $('.ue-back').parent().addClass('disabled');
    destroyQtips();
  });
  $('a[href$="#add-exec"]').click(function(event){
    event.preventDefault();
    $('.ue-next').empty().append('Next');
    $('.disabled.active').removeClass('disabled');
    $('.ue-back').parent().removeClass('disabled');
    destroyQtips();
  });
  $('a[href$="#cart"]').click(function(event){
    event.preventDefault();
    $('.ue-next').empty().append('Submit');
    $('.disabled.active').removeClass('disabled');
    $('.ue-back').parent().removeClass('disabled');
    destroyQtips();
    fillSummary();
  });

  function fillSummary () {
    $collection_title = $('#inputTitle').val();
    $collection_description = $('#inputDesc').val();
    $('#cart h1').text($collection_title);
    $('#cart h3 small').text($collection_description);
  }

  function destroyQtips () {
    destroyQtip($('#inputDesc'));
    destroyQtip($('#inputTitle'));
    destroyQtip($('a[href="#cart"]'));
    destroyQtip($('a[href="#title-desc"]'));
  }

});
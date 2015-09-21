function init_filters() {
    // no display if filters not aviable
    if ($("div").is("#filters")) {
        $('#button_filters').show();
        $('.button-collapse-right').sideNav({ edge: 'right' });
        $('#clear_form_filters').on('click', function(){
            $('#filters input').val('');
            $('#filters :checked').removeAttr('checked');
            return false;
        });
    }
}

function init_comments() {
  var offsetcom, offset, domPath, paragraph;
  var paragraphsSelector = $('p, blockquote > p, aside > p');
  var commentselector = $('.comment');
  var comment = new Array();
  var commentdomints = $('.commentdom');

  for (var i = 0; i < commentselector.length; i++) {

    // define paragraph for comment
    comment['dom'] = commentdomints.eq(i).text();

    // get paragraph id associated to comment
    comment['paragraphid'] = paragraphsSelector.eq(comment['dom']).attr('id');
    
    // set anchor for return button to paragraph
    commentselector.eq(i).find('.return-to-paragraph').attr('href', '#' + comment['paragraphid']);
  };

      

  /*
   * Hide comment form if user clicks elsewhere
   */

  $(document).mouseup(function (e)
  {
    var container = $(".nav-panel-add-comment");

    if (!container.is(e.target) // if the target of the click isn't the container...
        && container.has(e.target).length === 0) // ... nor a descendant of the container
    {
        container.hide();
    }
  });

  /*
   * Show comment button when hoovering a paragraph
   */

  $('article p, article blockquote, article aside').mouseover(function(e) {
    paragraph = $(this);
    offsetcom = paragraph.offset();
    domPath = $(this).index();
    //console.log(domPath);
    $("#new-comment-button").show();
    $("#new-comment-button").offset({ top: offsetcom.top, left: (offsetcom.left + em(55)) });
    
});
  /*
   * Add the comment input textarea when clicking on button
   */

  $('#new-comment-button').click(function(e) {
    $('.nav-panel-add-comment').show();
    $(".nav-panel-add-comment").offset({ top: offsetcom.top, left: offsetcom.left + em(57)});
    $("#comment_content").focus();
    console.log("dom path" + domPath);
    $(".nav-panel-add-comment #comment_dom").val(domPath);
});

}

function em(input) {
  var emSize = parseFloat($("body").css("font-size"));
  return (emSize * input);
}

function getDisplayType (element) {
    var cStyle = element.currentStyle || window.getComputedStyle(element, ""); 
    return cStyle.display;
}

$(document).ready(function(){
    // sideNav
    $('.button-collapse').sideNav();
    $('select').material_select();
    $('.collapsible').collapsible({
        accordion : false
    });
    $('.datepicker').pickadate({
        selectMonths: true,
        selectYears: 15,
        formatSubmit: 'dd/mm/yyyy',
        hiddenName: true,
        format: 'dd/mm/yyyy',
    });
    init_filters();

    $('#nav-btn-add-tag').on('click', function(){
       $(".nav-panel-add-tag").toggle(100);
       $(".nav-panel-menu").addClass('hidden');
       $("#tag_label").focus();
       return false;
    });

    $('#nav-btn-add-comment').on('click', function(){
       $(".nav-panel-add-comment").toggle(100);
       $(".nav-panel-menu").addClass('hidden');
       $("#comment_label").focus();
       $('html, body').animate({
          scrollTop: $("#comments").offset().top
        }, 1000);
       return false;
    });

    $('#nav-btn-add').on('click', function(){
       $(".nav-panel-buttom").hide(100);
       $(".nav-panel-add").show(100);
       $(".nav-panels .action").hide(100);
       $(".nav-panel-menu").addClass('hidden');
       $(".nav-panels").css('background', 'white');
       $("#entry_url").focus();
       return false;
    });
    $('#nav-btn-search').on('click', function(){
        $(".nav-panel-buttom").hide(100);
        $(".nav-panel-search").show(100);
        $(".nav-panels .action").hide(100);
        $(".nav-panel-menu").addClass('hidden');
        $(".nav-panels").css('background', 'white');
        $("#searchfield").focus();
        return false;
    });
    $('.mdi-navigation-close').on('click', function(){
        $(".nav-panel-add").hide(100);
        $(".nav-panel-search").hide(100);
        $(".nav-panel-buttom").show(100);
        $(".nav-panels .action").show(100);
        $(".nav-panel-menu").removeClass('hidden');
        $(".nav-panels").css('background', 'transparent');
        return false;
    });
    $(window).scroll(function () {
        var s = $(window).scrollTop(),
        d = $(document).height(),
        c = $(window).height();
        var scrollPercent = (s / (d-c)) * 100;
        $(".progress .determinate").css('width', scrollPercent+'%');
    });
    init_comments();
});

/* global jQuery */

jQuery(document).ready(function ($) {
  var tabNav = $('.nav-tab')
  var tabContainer = $('.nav-container')

  tabNav.click(function () {
    // remove active class from each tab
    tabNav.removeClass('tab-nav-active')
    // add class to self
    $(this).addClass('tab-nav-active')
    // get tab index
    var index = $(this).index('.nav-tab')
    // hide all tab containers
    tabContainer.addClass('hidden')
    // show right container
    tabContainer.eq(index).removeClass('hidden')
  })
})

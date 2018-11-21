/* global jQuery, tinyMCE */
jQuery(document).ready(function ($) {
  $('.js-add-form-tag').on('click', function () {
    const type = $(this).data('type')

    if (type === 'col') { addToEditor('[col][/col]') }
    if (type === 'hidden') { addToEditor('[input_hidden name="" value=""]') }
    if (type === 'text' ||
        type === 'url' ||
        type === 'tel' ||
        type === 'number' ||
        type === 'email'
      ) { addToEditor(getRegularInputShortcode(type)) }
    if (type === 'textarea') { addToEditor('[textarea name="" label="" width="u-1/2@m" required="required" error=""]') }
    if (type === 'select') { addToEditor('[select name="" values="" labels="" label="" width="u-1/2@m" required="required" error=""]') }
    if (type === 'checkbox') { addToEditor('[checkbox name="" value="" label="" float="float" required="required" error=""]') }
    if (type === 'radio') { addToEditor('[radio name="" values="" labels="" float="float"]') }
    if (type === 'submit') { addToEditor('[submit style="primary js-loading-button" content="Verzenden" width="u-1/1@m"]') }
  })

  function getRegularInputShortcode (type) {
    return '[input type="' + type + '" name="" label="" placeholder="" width="1/2" required="required" error=""]'
  }

  function addToEditor (content) {
    if (tinyMCE.activeEditor === null) {
      const editor = $('#form_editor')
      $('#form_editor').val(editor.val() + content)
    } else {
      tinyMCE.activeEditor.execCommand('mceInsertContent', false, content)
    }
  }
})

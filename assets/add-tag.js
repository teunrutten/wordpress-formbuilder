/* global jQuery, tinyMCE */
jQuery(document).ready(function ($) {
  $('.js-add-form-tag').on('click', function () {
    const type = $(this).data('type')
    console.log(type)

    if (type === 'col') { addToEditor('[col]   [/col]') }
    if (type === 'hidden') { addToEditor('[input_hidden name="" value=""]') }
    if (type === 'text' ||
        type === 'url' ||
        type === 'tel' ||
        type === 'number' ||
        type === 'email'
      ) { addToEditor(getRegularInputShortcode(type)) }
    if (type === 'textarea') { addToEditor('[textarea name="" value="" placeholder="" autocomplete="" pattern="" width="1/2" required="required"]') }
    if (type === 'select') { addToEditor('[select name="" values="" labels="" label="" placeholder="" pattern="" width="1/2" required="required"]') }
    if (type === 'checkbox') { addToEditor('[checkbox name="" value="" label="" float required="required"]') }
    if (type === 'radio') { addToEditor('[radio name="" values="" labels="" float]') }
    if (type === 'submit') { addToEditor('[submit style="primary" content="Verzenden" size="medium" width="1/2"]') }
  })

  function getRegularInputShortcode (type) {
    return '[input type="' + type + '" name="" value="" label="" placeholder="" autocomplete="" pattern="" width="1/2" required="required"]'
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

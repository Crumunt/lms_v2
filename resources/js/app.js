import './bootstrap';

import tinymce from 'tinymce';
import 'tinymce/icons/default';
import 'tinymce/themes/silver';
import 'tinymce/models/dom';
import 'tinymce/plugins/link';
import 'tinymce/plugins/code';
import 'tinymce/plugins/lists';
import 'tinymce/plugins/image';

tinymce.init({
  selector: '#editor',
  license_key: 'gpl',
  plugins: 'link image code lists wordcount',
  toolbar: 'undo redo | bold italic | bullist numlist | link image | code',
  setup: function (editor) {
    editor.on('input', function () {
      const count = editor.plugins.wordcount.body.getCharacterCount();
      document.getElementById('charCount').textContent = `${count} / 255`;
    });
  }
});

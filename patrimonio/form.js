function selectOnlyThis(id){
    var tipo = document.getElementsByName("estado");
    Array.prototype.forEach.call(tipo,function(el){
        el.checked = false;
    });
    id.checked = true;
  }

  function exportarXML() {
    const form = document.getElementById("formu");
    const formData = new FormData(form);
    let xml = '<?xml version="1.0" encoding="UTF-8"?>\n<formulario>\n';

    formData.forEach((value, key) => {
        if (Array.isArray(value)) {
            value.forEach(val => {
                xml += `  <${key}>${val}</${key}>\n`;
            });
        } else {
            xml += `  <${key}>${value}</${key}>\n`;
        }
    });

    xml += '</formulario>';

    const blob = new Blob([xml], { type: 'application/xml' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'formulario.xml';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
}

function exportarXLSX() {
    const form = document.getElementById("formu");
    const formData = new FormData(form);
    const data = [];

    formData.forEach((value, key) => {
        data.push([key, value]);
    });

    const worksheet = XLSX.utils.aoa_to_sheet([['Campo', 'Valor'], ...data]);
    const workbook = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(workbook, worksheet, "Formulário");

    XLSX.writeFile(workbook, 'formulario.xlsx');
}



// function previewImage(event) {
//     const fileInput = event.target;
//     const file = fileInput.files[0];
//     const fileNameDisplay = document.getElementById('img');
//     const imagePreview = document.getElementById('imagePreview');
//     const previewContainer = document.getElementById('previewContainer');
//     const imageDelete = document.getElementById('imageDelete');
//     const uploadWrapper = document.getElementById('uploadWrapper');

    
//     if (file) {
//         fileNameDisplay.textContent = file.name;
//     }

//     const reader = new FileReader();
//     reader.onload = function () {
//         imagePreview.src = reader.result;
//         imagePreview.style.display = 'block';
//         previewContainer.style.display = 'flex';
//         imageDelete.style.display = 'block';
//         uploadWrapper.style.display = 'none';
//     };
//     reader.readAsDataURL(file);
//     fileInput.value = '';
// }

// function deleteImg(event) {
//     event.preventDefault()
//     const imageDelete = document.getElementById('imageDelete');
//     const fileNameDisplay = document.getElementById('img');
//     const imagePreview = document.getElementById('imagePreview');
//     const uploadWrapper = document.getElementById('uploadWrapper');
//     const previewContainer = document.getElementById('previewContainer');
//     console.log(uploadWrapper)
//     imagePreview.src = '';
//     imageDelete.style.display = 'none';
//     previewContainer.style.display = 'none';
//     uploadWrapper.style.display = 'flex';
//     // uploadWrapper.style.paddingBottom = '3rem';
//     fileNameDisplay.textContent = '';
// }

function displayFileName(event) {
    const fileName = event.target.files[0]?.name;  // Obtém o nome do arquivo
    const fileNameDisplay = document.getElementById('file-name');  // O elemento onde exibimos o nome

    if (fileName) {
        fileNameDisplay.textContent = fileName;  // Exibe o nome do arquivo no span
    } else {
        fileNameDisplay.textContent = '';  // Caso o usuário não selecione um arquivo
    }
}

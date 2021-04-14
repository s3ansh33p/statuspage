let editData = {
    'service' : {
        'title': 'Service',
        'fields' : ['Status','Link','Tag']
    },
    'update' : {
        'title': 'Update',
        'fields' : ['Service','Title','Description']
    },
};  

let selElem, addType, preValues, curFormat;

function edit(e) {
    selElem = e;
    curFormat = editData[Object.getOwnPropertyNames(editData)[['LI','H4'].indexOf(selElem.parentElement.tagName)]];
    if (curFormat.title == "Service") {
        preValues = [selElem.parentElement.children[1].innerText.trim(),selElem.parentElement.children[0].innerText.trim()];
    } else if (curFormat.title == "Update") {
        preValues = [selElem.parentElement.children[0].innerText.trim(),selElem.parentElement.children[1].innerText.trim(), selElem.parentElement.parentElement.children[2].innerText.trim()];
    } else {
        preValues = [selElem.parentElement.parentElement.children[0].innerText.trim(), selElem.parentElement.innerText.trim()];
    }
}

function add(e) {
    addType = e.parentElement.innerText.trim().slice(0,-1);
}

$(document).ready(function () {

    $('#field-selected-user').on('change', (e) => {
        let curUser = users.find(user => user.id == e.target.value);
        $('#field-root-username').val(curUser.username);
        $('#field-root-email').val(curUser.email);
    })

    $('#editModal').on('show.bs.modal', function (event) {
        var modal = $(this)
        let toEdit = null;
        modal.find('.modal-title').text(`Edit ${curFormat.title}`)
        let formData = '';
        if (curFormat.title == "Service") {
            let status = selElem.parentElement.children[2].innerText;
            formData += `<div class="input-group mb-3">
            <div class="input-group-prepend">
              <label class="input-group-text" for="field-${curFormat.fields[0]}">Status</label>
            </div>
            <select class="custom-select" id="field-${curFormat.fields[0]}" name="${curFormat.fields[0].toLowerCase()}">
              <option ${(status == "Operational") ? 'selected ' : ''}value="1">Operational</option>
              <option ${(status == "Minor Outage") ? 'selected ' : ''}value="2">Minor Outage</option>
              <option ${(status == "Critical Outage") ? 'selected ' : ''}value="3">Critical Outage</option>
            </select>
            </div>`;
            for (let i=1; i<curFormat.fields.length; i++) {
                formData += `<div class="form-group">
                <label for="field-${curFormat.fields[i].toLowerCase()}" class="col-form-label">${curFormat.fields[i]}:</label>
                <input required value="${preValues[(i-1)]}" type="text" class="form-control" id="field-${curFormat.fields[i].toLowerCase()}" name="${curFormat.fields[i].toLowerCase()}">
                </div>`;
            };
        } else {
            for (let i=0; i<curFormat.fields.length; i++) {
                if (curFormat.fields[i] == "Service") {
                    let serviceOptions = '';
                    for (let j=0; j<services.length; j++) {
                        serviceOptions += `<option ${(preValues[i] == services[j].serviceTag) ? 'selected ' : ''}value="${services[j].id}">${services[j].serviceTag}</option>`;
                    };
                    formData += `<div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <label class="input-group-text" for="field-${curFormat.fields[i].toLowerCase()}">Service</label>
                    </div>
                    <select required class="custom-select" id="field-${curFormat.fields[i].toLowerCase()}" name="${curFormat.fields[i].toLowerCase()}">
                      ${serviceOptions}
                    </select>
                  </div>`;
                } else if (curFormat.fields[i] == "Description") {
                    formData += `<div class="form-group">
                    <label for="field-${curFormat.fields[i].toLowerCase()}" class="col-form-label">${curFormat.fields[i]}:</label>
                    <textarea class="form-control" id="field-${curFormat.fields[i].toLowerCase()}" name="${curFormat.fields[i].toLowerCase()}"></textarea>
                    </div>`;
                    toEdit = i;
                } else {
                    formData += `<div class="form-group">
                    <label for="field-${curFormat.fields[i].toLowerCase()}" class="col-form-label">${curFormat.fields[i]}:</label>
                    <input required value="${preValues[i]}" type="text" class="form-control" id="field-${curFormat.fields[i].toLowerCase()}" name="${curFormat.fields[i].toLowerCase()}">
                    </div>`;
                };
            };
        }
        let editID = selElem.parentElement.id
        formData += `<input type="hidden" name="edit-section" value="${editID}">`;
        modal.find('.modal-body data').html(formData);
        if (toEdit != null) {
            document.getElementById(`field-${curFormat.fields[toEdit].toLowerCase()}`).value = preValues[toEdit];
        }
    })
    $('#addModal').on('show.bs.modal', function (event) {
        var modal = $(this)
        let formData = '';
        if (addType == "Update") {
            let serviceOptions = '';
            for (let j=0; j<services.length; j++) {
                serviceOptions += `<option value="${services[j].id}">${services[j].serviceTag}</option>`;
            };
            formData += `<div class="input-group mb-3">
            <div class="input-group-prepend">
            <label class="input-group-text" for="field-service">Service</label>
            </div>
                <select required class="custom-select" id="field-service" name="service">
                ${serviceOptions}
                </select>
            </div>`;
            for (let i=1; i<editData['update'].fields.length; i++) {
                formData += `<div class="form-group">
                <label for="field-${editData['update'].fields[i].toLowerCase()}" class="col-form-label">${editData['update'].fields[i]}:</label>
                <input required type="text" class="form-control" id="field-${editData['update'].fields[i].toLowerCase()}" name="${editData['update'].fields[i].toLowerCase()}">
                </div>`;
            };
        } else {
            formData += `<div class="input-group mb-3">
            <div class="input-group-prepend">
              <label class="input-group-text" for="field-status">Status</label>
            </div>
            <select required class="custom-select" id="field-status" name="status">
              <option selected value="1">Operational</option>
              <option value="2">Minor Outage</option>
              <option value="3">Critical Outage</option>
            </select>
            </div>`;
            let serv = ['Link','Tag'];
            for (let i=0; i<serv.length; i++) {
                formData += `<div class="form-group">
                <label for="field-${serv[i].toLowerCase()}" class="col-form-label">${serv[i]}:</label>
                <input required type="text" class="form-control" id="field-${serv[i].toLowerCase()}" name="${serv[i].toLowerCase()}">
                </div>`;
            };
        }
      formData += `<input type="hidden" name="edit-section" value="${addType.toLowerCase()}">`;
        modal.find('.modal-title').text(`Add ${addType}`);
        modal.find('#add-btn').text(`Add ${addType}`);
        modal.find('.modal-body data').html(formData);
    })
});
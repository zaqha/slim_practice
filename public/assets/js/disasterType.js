$(document).ready(function () {

    $('#formModifyRole').submit(function (e) {
        // console.log(event);
        var modal = $(this)
        if (!modal.find('.modal-body input:not([type=hidden])').val()) {
            alert('名稱請勿空白')
        }
    })

    $('#modalModifyRole').on('show.bs.modal', function (event) {


        var button = $(event.relatedTarget) // Button that triggered the modal
        var recipient = button.data('whatever') // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        // console.log(modal);
        var id = button.parent().parent().find('input:radio').val()
        var text = button.parent().parent()[0].innerText
        modal.find('.modal-body input:not([type=hidden])').val(text)
        modal.find('.modal-body input[type=hidden]').val(id)
    })

    $('#modalRemoveRole').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        var id = button.parent().parent().find('input:radio').val()
        console.log(id)
        // console.log(text)
        modal.find('.modal-body input[type=hidden]').val(id)
    })
})


// 大項新增
$(document).on('click', '#btnAddAboveType', function () {
    var getUrl = window.location;
    if (!$('#newRoleName').val()) {
        alert('大項名稱請勿空白');
    } else {
        $.post(getUrl + '/aboveInsert', {
            name: $('#newRoleName').val()
        }, function (data) {
            $('.btnRemoveFunction').on('click', function () {
                $(this).parent().remove();
            });
            bootbox.alert('新增成功');
            location.reload();
        })
    }

})

// 細項新增
$(document).on('click', '#btnAddSubStype', function () {
    var getUrl = window.location;
    if (!$('#subName').val()) {
        alert('細項名稱請勿空白');
    } else {

        $.post(getUrl + '/subInsert', {
            subName: $('#subName').val(),
            authority: $('#authority').val(),
            parent_id: $('#parent_id').val()
        }, function (data) {
            bootbox.alert('新增成功');
            $('.btnRemoveFunction').on('click', function () {
                $(this).parent().remove();
            });
            parent_id = $('#parent_id').val()
            $('#radioRole' + parent_id).click()
            // console.log('#radioRole'+parent_id)
        })
    }

})

$('#above_edit').click(function (e) {
    e.preventDefault()
    $.ajax({
        url: location.href + '/aboveUpdate',
        method: 'POST',
        data: {
            aboveName: $("input[name='aboveName']").val(),
            aboveId: $("input[name='aboveId']").val(),
        }
    }).done(function () {
        bootbox.alert("儲存成功", function () {
            location.reload()
        })
    }).fail(function () {
        bootbox.alert("儲存失敗，請檢查網路連線", function () {
            location.reload()
        })
    })
})


// 大項刪除
$('.btnRemoveRole').click(function () {
    AboveID = $(this).parent().parent().find('input[name="roleRadio[]"]').val()

    bootbox.confirm('您確定要刪除嗎?', function (result) {
        if (result) {
            $.ajax({
                url: location.href + '/aboveDelete',
                method: 'POST',
                data: {
                    id: AboveID
                }
            }).done(function () {
                bootbox.alert('刪除成功', function () {
                    location.reload()
                })
            }).fail(function () {
                bootbox.alert('刪除失敗', function () {
                    location.reload()
                })
            })
        }
    })
})



// 編輯點擊顯示
$('.subEdit').on('click', function () {
    id = $(this).attr("data-id");
    name = $(this).attr("data-name");
    authority_edit = $(this).attr("data-authority");
    parent = $(this).attr("data-parent");
    $('input[name=subName_edit]').val(name);
    $('input[name=subId_edit]').val(id);
    $('input[name=authority_edit]').val(authority_edit);
    $('input[name=parentId_edit]').val(parent);
});


$('#sub_edit').click(function (e) {
    e.preventDefault();
    $.ajax({
        url: location.href + '/subUpdate',
        method: 'POST',
        data: {
            subName: $("input[name='subName_edit']").val(),
            authority: $("input[name='authority_edit']").val(),
            subId: $("input[name='subId_edit']").val(),
        }
    }).done(function () {
        bootbox.alert("儲存成功", function () {
            $('.modal-backdrop').hide();
            parent_id = $("input[name='parentId_edit']").val()
            $('#radioRole' + parent_id).click()
        })
    }).fail(function () {
        bootbox.alert("儲存失敗，請檢查網路連線", function () {
            location.reload()
        })
    })
})


// 細項刪除
$('.btnRemoveSub').click(function () {
    SubID = $(this).attr("data-id");
    parent = $(this).attr("data-parent");

    bootbox.confirm('您確定要刪除嗎?', function (result) {
        if (result) {
            $.ajax({
                url: location.href + '/subDelete',
                method: 'POST',
                data: {
                    id: SubID
                }
            }).done(function () {
                bootbox.alert('刪除成功', function () {
                    $('#radioRole' + parent).click()
                })
            }).fail(function () {
                bootbox.alert('刪除失敗', function () {
                    location.reload()
                })
            })
        }
    })
})
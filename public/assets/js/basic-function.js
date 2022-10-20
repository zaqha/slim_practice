// Example starter JavaScript for disabling form submissions if there are invalid fields
(function() {
    'use strict';
    window.addEventListener('load', function() {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();

// delete setting page item
$('.btnDeleteSettingItem').click(function(event) {
    itemObj = $(this).parent().parent().remove();
})

// add setting page item
$('#btnAddSettingItem').click(function(event) {
    var clonedObj = $('.setting-template').clone(true);
    // console.log(lastIndex);

    //clear all the user input
    clonedObj.show()
    clonedObj.removeClass('setting-template')
    clonedObj.addClass('setting-row')
    clonedObj.find('input:hidden').val('');
    clonedObj.find('input:text').val('');
    clonedObj.find('select').val('')
    clonedObj.appendTo(".tableSetting");

})

$('#accordionSidebar a:not(.root-node)').click(function() {
    // console.log(1)
    localStorage.setItem('clickedSidebar', $(this).attr('href'))
})

$('#accordionSidebar .subroot-node').click(function() {
    // console.log(1)
    localStorage.setItem('clickedSidebar', $(this).children('div').data('href'))
})

$('#accordionSidebar .sp-node').click(function() {
    // console.log(2)
    localStorage.setItem('clickedSidebar', $(this).data('href'))

})

// 專案目錄名稱
var directoryName = location.pathname.split('/')[1]

$(document).ready(function(e) {

    // 設定bootbox語系
    bootbox.setLocale('zh_TW')
    // 抓取提醒鈴鐺數字並存於localStorage
    $.ajax({
        type: 'GET',
        url: location.origin + "/" + directoryName + "/get-notification-num"
    }).done(function(data, msg, obj) {

        localStorage.setItem('rejectedReportNumber', data.rejectedReportNumber)
        localStorage.setItem('unsignedReportNumber', data.unsignedReportNumber)
        localStorage.setItem('assignmentFromListNumber', data.assignmentFromListNumber)
        localStorage.setItem('assignmentToListNumber', data.assignmentToListNumber)
    })

    // 取消form裡面input欄位的enter鍵功能，但忽略輸入帳密畫面
    $('form input').not($("#formLogin").find('input')).keydown(function(event) {
        if (event.keyCode == 13) {
            event.preventDefault();
            return false;
        }
    });

    // highlight clicked sidebar
    if (localStorage.getItem('clickedSidebar') === null) {
        localStorage.setItem('clickedSidebar', '')
        // console.log('GG')
    } else {
        // console.log('GGG')
        // save clicked href

        $('#accordionSidebar a:not(.root-node,.subroot-node)').each(function() {

            if (localStorage.getItem('clickedSidebar') == $(this).attr('href') &&
                localStorage.getItem('clickedSidebar') != '#' &&
                localStorage.getItem('clickedSidebar') != '' &&
                localStorage.getItem('clickedSidebar') != "/" + directoryName + "/") {
                // change clicked item background color
                $(this).css('background-color', '#FAD8A9')
                // find all the ancestors which is collapse and show them
                $(this).parents('.collapse').collapse('show')

            }

            // 如果點擊的是首頁
            if (localStorage.getItem('clickedSidebar') == $(this).attr('href') &&
                localStorage.getItem('clickedSidebar') == "/" + directoryName + "/") {
                $(this).css('background', 'linear-gradient(#9DC0DF, #9DC0DF) bottom no-repeat')
                $(this).css('background-size', '90% 2px')
                // $(this).children('i').css('color', '#FFFFFF')
                // $(this).children('span').css('color', '#FFFFFF')
                // $(this).css('border', '1px #FFFFFF solid')
                // $(this).css('border', '1px #000000 dotted')
            }

        })

        $('#accordionSidebar .subroot-node').each(function() {
            // console.log($(this).children('div').data('href'))
            if (localStorage.getItem('clickedSidebar') == $(this).children('div').data('href') &&
                $(this).hasClass('subroot-node')) {
                // change clicked item background color
                $(this).css('background-color', '#FAD8A9')
                // find all the ancestors which is collapse and show them
                $(this).parents().parents('.collapse').collapse('show')
            }
        })
    }

})

$(document).on('click', '#btnLogout', function() {
    localStorage.setItem('clickedSidebar', '')
    location.href = location.origin + "/" + directoryName + "/logout"
})



function hasEmptyValue(ele) {

    return $(ele).filter(function() {
        return $(this).val() == '' || $(this).val() == null;
    }).length > 0;
}

function hasStrangeHour(ele) {
    return $(ele).filter(function() {
        // console.log($(this).val())
        // console.log(parseInt($(this).val()))
        // console.log(typeof $(this).val())
        return $(this).val() < 0.08 || $(this).val() > 24 || isNaN(parseFloat($(this).val())) == true;
    }).length > 0;
}

function hasSameValue(ele) {
    var arr = []
    var hasSame = false
    $(ele).each(function() {
        // console.log($(this).val())
        var val = $(this).val();
        if (arr.indexOf(val) == -1) {
            arr.push(val)
        } else {
            hasSame = true
        }
    })

    return hasSame
}

function sumOfValue(ele) {
    let arr = $(ele).map(function() {
        return $(this).val()
    }).get()
    // console.log(arr)

    return arr.reduce(function(accumulator, currentValue) {
        // console.log(parseFloat(accumulator) + parseFloat(currentValue))
        return parseFloat(accumulator) + parseFloat(currentValue)
    })
}

// 於選擇人員視窗中新增人員
$(document).on('click', '#btnAddEmpToList', function(event) {   
    //get selected options in left side
    let addEmpDiv = $(this).parent()
    let arr = {}
    for (var n = 0; n < addEmpDiv.find('.left_emp option:selected').contents().length; n++) {
        arr[addEmpDiv.find('.left_emp option:selected').contents()[n].parentNode.value] =
            addEmpDiv.find('.left_emp option:selected').contents()[n].data;
    }

    //add to left side
    $.each(arr, function(i, item) {
        addEmpDiv.parent().find('.right_emp').append($('<option>', {
            value: i,
            text: item
        }));

        let duplicatedItem = addEmpDiv.parent().find('.left_emp option:contains(' + item + ")")
        // console.log(duplicatedItem)
        if (typeof duplicatedItem !== 'undefined') {
            // console.log($('.left_emp option:contains(' + item + ")"))
            addEmpDiv.find('.left_emp option:contains(' + item + ")").remove()
        }
    })
})

// 於選擇人員視窗中新增所有人員 2022.04.22 Anderson 新增工作項目時可決定是否將所有員工代入成員清單
$(document).on('click', '#btnAddAllEmpToList', function(event) {
    //get selected options in left side
    let addEmpDiv = $(this).parent()
    let arr = {}
    $('.left_emp option').prop('selected', 'selected');
    for (var n = 0; n < addEmpDiv.find('.left_emp option:selected').contents().length; n++) {
        arr[addEmpDiv.find('.left_emp option:selected').contents()[n].parentNode.value] =
            addEmpDiv.find('.left_emp option:selected').contents()[n].data;
    }
    
    // console.log(arr)
    //add to left side
    $.each(arr, function(i, item) {
        addEmpDiv.parent().find('.right_emp').append($('<option>', {
            value: i,
            text: item
        }));

        let duplicatedItem = addEmpDiv.parent().find('.left_emp option:contains(' + item + ")")
        // console.log(duplicatedItem)
        if (typeof duplicatedItem !== 'undefined') {
            // console.log($('.left_emp option:contains(' + item + ")"))
            addEmpDiv.find('.left_emp option:contains(' + item + ")").remove()
        }
    })
})

//於選擇人員視窗中新增人員
function addName(IDArr, nameArr) {
    //get selected options in left side

    let arr = {}
    if (IDArr == '') {

        for (var n = 0; n < $('.left_emp option:selected').contents().length; n++) {
            arr[$('.left_emp option:selected').contents()[n].parentNode.value] = $('.left_emp option:selected').contents()[n].data;
        }
    } else {
        for (var n = 0; n < IDArr.length; n++) {
            arr[IDArr[n]] = nameArr[n];
        }
    }
    // console.log(IDArr)
    // console.log(nameArr)
    //add to left side
    $.each(arr, function(i, item) {
        $('.right_emp').append($('<option>', {
            value: i,
            text: item
        }));

        let duplicatedItem = $('.left_emp option:contains(' + item + ")")
        // console.log(duplicatedItem)
        if (typeof duplicatedItem !== 'undefined') {
            // console.log($('.left_emp option:contains(' + item + ")"))
            $('.left_emp option:contains(' + item + ")").remove()
        }
    })

}

//於選擇人員視窗中刪除人員
$(document).on('click', '#btnDeleteEmpFromList', function(event) {
    // console.log($(this).parent())
    let deleteEmpDiv = $(this).parent()
    let arr2 = {};
    for (var n = 0; n < deleteEmpDiv.find('.right_emp option:selected').contents().length; n++) {
        arr2[deleteEmpDiv.parent().find('.right_emp option:selected').contents()[n].parentNode.value] = deleteEmpDiv.parent().find('.right_emp option:selected').contents()[n].data;
    }

    $.each(arr2, function(i, item) {
        // console.log($(this))
        deleteEmpDiv.parent().find('.left_emp').append($('<option>', {
            value: i,
            text: item
        }));

        deleteEmpDiv.find('.right_emp option:contains(' + item + ")")[0].remove();
    })
})

//於選擇人員視窗中刪除所有人員 2022.04.22 Anderson 新增工作項目時可決定是否將所有員工代入成員清單
$(document).on('click', '#btnDeleteAllEmpFromList', function(event) {
    // console.log($(this).parent())
    let deleteEmpDiv = $(this).parent()
    let arr2 = {};
    $('.right_emp option').prop('selected', 'selected');
    for (var n = 0; n < deleteEmpDiv.find('.right_emp option:selected').contents().length; n++) {
        arr2[deleteEmpDiv.parent().find('.right_emp option:selected').contents()[n].parentNode.value] = deleteEmpDiv.parent().find('.right_emp option:selected').contents()[n].data;
    }

    $.each(arr2, function(i, item) {
        // console.log($(this))
        deleteEmpDiv.parent().find('.left_emp').append($('<option>', {
            value: i,
            text: item
        }));

        deleteEmpDiv.find('.right_emp option:contains(' + item + ")")[0].remove();
    })
})

//於選擇人員視窗中刪除人員
function deleteName() {
    let arr2 = {};
    for (var n = 0; n < $('.right_emp option:selected').contents().length; n++) {
        arr2[$('.right_emp option:selected').contents()[n].parentNode.value] = $('.right_emp option:selected').contents()[n].data;
    }

    console.log(arr2);
    $.each(arr2, function(i, item) {
        $('.left_emp').append($('<option>', {
            value: i,
            text: item
        }));

        $('.right_emp option:contains(' + item + ")")[0].remove();
    })
}

function empSelectConfirm(column_id) {
    let confirmed_str = '';
    let id_str = '';
    $('.right_emp option').each(function(index) {
        if (index == $('.right_emp option').length - 1) {
            confirmed_str = confirmed_str + $(this).text();
            id_str = id_str + $(this).val();
        } else {
            confirmed_str = confirmed_str + $(this).text() + ',';
            id_str = id_str + $(this).val() + ',';
        }
    })

    $('#' + column_id + '_id').val(id_str);
    $('#' + column_id).val(confirmed_str);

    $('.userId').val(confirmed_str)
    $('input[name="userId"]').val(id_str)
    $('#modalSelectEmp').modal('hide')
}

// punch clock button event
$('#btnPunchIn').click(function(event) {

    navigator.geolocation.getCurrentPosition(function(position) {

        let lat = position.coords.latitude
        let long = position.coords.longitude

        $.ajax({
                type: "POST",
                url: location.origin + "/" + directoryName + "/punch-clock/in",
                data: {
                    lat: lat,
                    long: long
                }
            })
            .done(function(data, msg, obj) {
                location.reload()
            })
            .fail(function(obj, msg, err) {
                if (obj.responseText == 'ip error') {
                    bootbox.prompt({
                        title: "打卡裝置IP不在允許清單內，請填寫事由",
                        maxlength: 50,
                        required: true,
                        callback: function(result) {
                            if (result) {
                                $.ajax({
                                    type: "POST",
                                    url: location.origin + "/" + directoryName + "/punch-clock/in",
                                    data: {
                                        lat: lat,
                                        long: long,
                                        reason: result
                                    }
                                }).done(function() {
                                    location.reload()
                                }).fail(function() {
                                    bootbox.alert("打卡異常，請檢查網路連線")
                                })
                            }
                        }
                    })
                } else if (obj.responseText == 'location error') {
                    bootbox.prompt({
                        title: "打卡座標不在允許清單內，請填寫事由",
                        maxlength: 50,
                        required: true,
                        callback: function(result) {
                            if (result) {
                                $.ajax({
                                    type: "POST",
                                    url: location.origin + "/" + directoryName + "/punch-clock/in",
                                    data: {
                                        lat: lat,
                                        long: long,
                                        reason: result
                                    }
                                }).done(function() {
                                    location.reload()
                                }).fail(function() {
                                    bootbox.alert("打卡異常，請檢查網路連線")
                                })
                            }
                        }
                    })
                } else {
                    bootbox.alert("打卡異常，請檢查網路連線");
                }
            })
    })

})

$('#btnPunchOut').click(function(event) {
    navigator.geolocation.getCurrentPosition(function(position) {

        let lat = position.coords.latitude
        let long = position.coords.longitude

        $.ajax({
                type: "POST",
                url: location.origin + "/" + directoryName + "/punch-clock/out",
                data: {
                    lat: lat,
                    long: long
                }
            })
            .done(function(data, msg, obj) {
                location.reload()
            })
            .fail(function(obj, msg, err) {
                if (obj.responseText == 'ip error') {
                    bootbox.prompt({
                        title: "打卡裝置IP不在允許清單內，請填寫事由",
                        maxlength: 50,
                        required: true,
                        callback: function(result) {
                            if (result) {
                                $.ajax({
                                    type: "POST",
                                    url: location.origin + "/" + directoryName + "/punch-clock/out",
                                    data: {
                                        lat: lat,
                                        long: long,
                                        reason: result
                                    }
                                }).done(function() {
                                    location.reload()
                                }).fail(function() {
                                    bootbox.alert("打卡異常，請檢查網路連線")
                                })
                            }
                        }
                    })
                } else if (obj.responseText == 'location error') {
                    bootbox.prompt({
                        title: "打卡座標不在允許清單內，請填寫事由",
                        maxlength: 50,
                        required: true,
                        callback: function(result) {
                            if (result) {
                                $.ajax({
                                    type: "POST",
                                    url: location.origin + "/" + directoryName + "/punch-clock/out",
                                    data: {
                                        lat: lat,
                                        long: long,
                                        reason: result
                                    }
                                }).done(function() {
                                    location.reload()
                                }).fail(function() {
                                    bootbox.alert("打卡異常，請檢查網路連線")
                                })
                            }
                        }
                    })
                } else {
                    bootbox.alert("打卡異常，請檢查網路連線");
                }
            })
    })
})

$('#btnPunchInOvertime').click(function(event) {
    navigator.geolocation.getCurrentPosition(function(position) {

        let lat = position.coords.latitude
        let long = position.coords.longitude

        $.ajax({
                type: "POST",
                url: location.origin + "/" + directoryName + "/punch-clock/in-overtime",
                data: {
                    lat: lat,
                    long: long
                }
            })
            .done(function(data, msg, obj) {
                location.reload()
            })
            .fail(function(obj, msg, err) {
                if (obj.responseText == 'ip error') {
                    bootbox.prompt({
                        title: "打卡裝置IP不在允許清單內，請填寫事由",
                        maxlength: 50,
                        required: true,
                        callback: function(result) {
                            if (result) {
                                $.ajax({
                                    type: "POST",
                                    url: location.origin + "/" + directoryName + "/punch-clock/in-overtime",
                                    data: {
                                        lat: lat,
                                        long: long,
                                        reason: result
                                    }
                                }).done(function() {
                                    location.reload()
                                }).fail(function() {
                                    bootbox.alert("打卡異常，請檢查網路連線")
                                })
                            }
                        }
                    })
                } else if (obj.responseText == 'location error') {
                    bootbox.prompt({
                        title: "打卡座標IP不在允許清單內，請填寫事由",
                        maxlength: 50,
                        required: true,
                        callback: function(result) {
                            if (result) {
                                $.ajax({
                                    type: "POST",
                                    url: location.origin + "/" + directoryName + "/punch-clock/in-overtime",
                                    data: {
                                        lat: lat,
                                        long: long,
                                        reason: result
                                    }
                                }).done(function() {
                                    location.reload()
                                }).fail(function() {
                                    bootbox.alert("打卡異常，請檢查網路連線")
                                })
                            }
                        }
                    })
                } else {
                    bootbox.alert("打卡異常，請檢查網路連線");
                }
            })
    })
})

$('#btnPunchOutOvertime').click(function(event) {
    navigator.geolocation.getCurrentPosition(function(position) {

        let lat = position.coords.latitude
        let long = position.coords.longitude

        $.ajax({
                type: "POST",
                url: location.origin + "/" + directoryName + "/punch-clock/out-overtime",
                data: {
                    lat: lat,
                    long: long
                }
            })
            .done(function(data, msg, obj) {
                location.reload()
            })
            .fail(function(obj, msg, err) {
                if (obj.responseText == 'ip error') {
                    bootbox.prompt({
                        title: "打卡裝置IP不在允許清單內，請填寫事由",
                        maxlength: 50,
                        required: true,
                        callback: function(result) {
                            if (result) {
                                $.ajax({
                                    type: "POST",
                                    url: location.origin + "/" + directoryName + "/punch-clock/out-overtime",
                                    data: {
                                        lat: lat,
                                        long: long,
                                        reason: result
                                    }
                                }).done(function() {
                                    location.reload()
                                }).fail(function() {
                                    bootbox.alert("打卡異常，請檢查網路連線")
                                })
                            }
                        }
                    })
                } else if (obj.responseText == 'location error') {
                    bootbox.prompt({
                        title: "打卡座標不在允許清單內，請填寫事由",
                        maxlength: 50,
                        required: true,
                        callback: function(result) {
                            if (result) {
                                $.ajax({
                                    type: "POST",
                                    url: location.origin + "/" + directoryName + "/punch-clock/out-overtime",
                                    data: {
                                        lat: lat,
                                        long: long,
                                        reason: result
                                    }
                                }).done(function() {
                                    location.reload()
                                }).fail(function() {
                                    bootbox.alert("打卡異常，請檢查網路連線")
                                })
                            }
                        }
                    })
                } else {
                    bootbox.alert("打卡異常，請檢查網路連線");
                }
            })
    })
})

//super duper code to stack bootstrap modal
;
(function() {
    // bootstrap/scss/_variables.scss -> $zindex-modal
    var zIndexModal = 1050

    jQuery(document).on('show.bs.modal', '.modal', function(e) {
        var visibleModalsCount = jQuery('.modal:visible').length
        var zIndex = zIndexModal + (100 * visibleModalsCount)
        jQuery(e.target).css('z-index', zIndex)
        setTimeout(function() {
            jQuery('.modal-backdrop')
                .not('.modal-stack')
                .first()
                // bootstrap/scss/_variables.scss -> $zindex-modal-backdrop
                .css('z-index', zIndex - 10)
                .addClass('modal-stack')
        }, 0)

    })

    jQuery(document).on('hidden.bs.modal', '.modal', function() {
        if (jQuery('.modal:visible').length) {
            jQuery.fn.modal.Constructor.prototype._checkScrollbar()
            jQuery.fn.modal.Constructor.prototype._setScrollbar()
            jQuery('body').addClass('modal-open')
        }
    })
})();

// 新增交辦事項內選擇成員
$('#btnSelectEmp').click(function(event) {
    // console.log(event);
    $.post(location.origin + '/' + directoryName + '/get-emp-select-modal', function(data) {
        $('#modalSelectEmp .modal-content .modal-body').html(data);
    })
})

// 直接發出post request
function formPost(path, params, method = 'post') {

    // The rest of this code assumes you are not using a library.
    // It can be made less wordy if you use one.
    const form = document.createElement('form');
    form.method = method;
    form.action = path;

    for (const key in params) {
        if (params.hasOwnProperty(key)) {
            const hiddenField = document.createElement('input');
            hiddenField.type = 'hidden';
            hiddenField.name = key;
            hiddenField.value = params[key];

            form.appendChild(hiddenField);
        }
    }

    document.body.appendChild(form);
    form.submit();
}

$('#btnExportSalaryAnnualList').click(function() {
    $('#modalExportAnnualList').modal('hide')
    $('body').append('<div style="" id="loadingDiv"><div class="loader">Loading...</div></div>');
    // 取得年月
    var year = $('#selectExportAnnualListYear').val() - 1911
    var fileName = "資峰科技有限公司" + year.toString() + "年度薪資核對表.xlsx"
    $.ajax({
        url: location.origin + '/' + directoryName + "/emp-salary/export-annual-list",
        method: 'POST',
        xhr: function() {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 2) {
                    if (xhr.status == 200) {
                        xhr.responseType = "blob";
                    } else {
                        xhr.responseType = "text";
                    }
                }
            };
            return xhr;
        },
        data: {
            exportYear: $('#selectExportAnnualListYear').val()
        }
    }).done(function(data, status, request) {
        $("#loadingDiv").remove(); //makes page more lightweight
        var blob = new Blob([data], {
            type: "application/octetstream"
        });

        //Check the Browser type and download the File.
        var isIE = false || !!document.documentMode;
        if (isIE) {
            window.navigator.msSaveBlob(blob, fileName);
        } else {
            var url = window.URL || window.webkitURL;
            link = url.createObjectURL(blob);
            var a = $("<a />");
            a.attr("download", fileName);
            a.attr("href", link);
            $("body").append(a);
            a[0].click();
            $("body").remove(a);
        }
    }).fail(function() {
        $("#loadingDiv").remove(); //makes page more lightweight
    })
})

function notEqualAndLarger(e1, e2) {
    let notEqual = false
    let larger = false

    if (e1 != e2) {
        notEqual = true
    }

    if (e1 > e2) {
        larger = true
    }

    return notEqual && larger
}
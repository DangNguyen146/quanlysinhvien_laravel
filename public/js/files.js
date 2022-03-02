ClassicEditor.create(document.querySelector("#content"), {
    toolbar: [
        "bold",
        "italic",
        "link",
        "|",
        "bulletedList",
        "numberedList",
        "blockQuote",
    ],
}).catch((error) => {
    console.error(error);
});

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $(".image-upload-wrap").hide();

            $(".file-upload-image").attr("src", e.target.result);
            $(".file-upload-content").show();

            $(".image-title").html(input.files[0].name);
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        removeUpload();
    }
}

function removeUpload() {
    $(".file-upload-input").replaceWith($(".file-upload-input").clone());
    $(".file-upload-content").hide();
    $(".image-upload-wrap").show();
}
$(".image-upload-wrap").bind("dragover", function () {
    $(".image-upload-wrap").addClass("image-dropping");
});
$(".image-upload-wrap").bind("dragleave", function () {
    $(".image-upload-wrap").removeClass("image-dropping");
});
var x = jQuery.noConflict();
x(document).ready(function () {
    x("#idCat").on("change", function () {
        var idCat = x("#idCat").val();
        getOptionPost(idCat);
    });

    function getOptionPost(idCat) {
        x.ajax({
            type: "get",
            url: "/api/get-option-post",
            data: {
                idCat: idCat,
            },
            success: function (result) {
                // console.log(result);
                var re = JSON.parse(result);
                console.log(re);
                if (re.status == "FALSE") {
                    x("#idPostHelp").addClass("error").html(re.message);
                    x("#spanIdPost > span > span > .select2-selection")
                        .removeClass("border-success")
                        .addClass("border-danger");
                    x("#idPost")
                        .addClass("is-invalid")
                        .removeClass("is-valid")
                        .html(re.result);
                } else {
                    x("#idPostHelp").removeClass("error").html(re.message);
                    x("#spanIdPost > span > span > .select2-selection")
                        .removeClass("border-danger")
                        .addClass("border-success");
                    x("#idPost").html(re.result);
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                console.log("Status: " + textStatus);
                alert("Error: " + errorThrown);
            },
        });
    }
});
var x = jQuery.noConflict();
x(document).ready(function () {
  x.ajaxSetup({
    headers: {
      "X-CSRF-TOKEN": x('input[name="_token"]').attr("value"),
    },
  });
  x("#filetailieu").on("click", function () {
    x("#filetailieu").removeClass("is-valid").addClass("is-invalid").val("");
    x("#fileHelp").addClass("error").html("Chưa tập tin nào được chọn");
    x("[for=filetailieu]").html("Chọn...");
  });
  x("#filetailieu").on("change", function () {
    checkFile();
  });
  x(".btn-fileclear").on("click", function () {
    x("#filetailieu").attr("required");
    x("#filetailieu").removeClass("is-valid").addClass("is-invalid").val("");
    x("#fileHelp").addClass("error").html("Chưa tập tin nào được chọn");
    x("[for=filetailieu]").html("Chọn...");
  });
  x(".btn-fileback").on("click", function () {
    var idFile = x("#title").attr("idFile");
    var button = x(this);
    getInfoFile(button, idFile);
  });
  x("#idCat").on("change", function () {
    var idCat = x("#idCat").val();
    getOptionPost(idCat);
  });
  x("#title").on("focusout", function () {
    inputNotNull("#title", "Tên Tài liệu không được bỏ trống");
  });
  x("form").on("submit", function () {
    var button = x("#submit");
    loadBtn(button);
    //post(button);
  });
  x(".delete-badge").on("click", function () {
    var title = x(this).attr("titleFile");
    var id = x(this).attr("idFile");
    x("#deleteFileId").attr("idFile", id);
    x("strong.titleFile").html(title);
  });
  x("#deleteFile").on("click", function () {
    var button = x(this);
    loadBtn(button);
    deletefile();
  });
  x("#deleteFileId").on("click", function () {
    var button = x(this);
    var id = x(this).attr("idFile");
    loadBtn(button);
    deletefileid(id);
  });
  // Xem trước hình ảnh
  x("#img-select").on("click", function () {
    x("#img-view").attr("src", "");
    x("#img-clear").addClass("hidden");
    x("#imgfile").click();
  });
  x("#imgfile").on("change", reviewUpload);
  function reviewUpload(event) {
    var files = event.target.files;
    if (typeof files[0] != "undefined") {
      var url = URL.createObjectURL(files[0]);
      x("#img-clear").removeClass("hidden");
      x("#img-select").addClass("hidden");
      x("#img-view").attr("src", url);
    }
  }
  x("#img-clear").on("click", function () {
    x(this).addClass("hidden");
    x("#img-select").removeClass("hidden");
    x("#img-re").removeClass("hidden");
    x("#img-view").attr("src", "");
    x("#imgfile").val("");
  });
  x("#img-re").on("click", function () {
    x(this).addClass("hidden");
    x("#img-clear").removeClass("hidden");
    x("#img-select").addClass("hidden");
    x("#img-view").attr("src", x(this).attr("urlImg"));
    x("#imgfile").val("");
  });
  function extend(obj, src) {
    for (var key in src) {
      if (src.hasOwnProperty(key)) obj[key] = src[key];
    }
    return obj;
  }
  function getOptionPost(idCat) {
    x.ajax({
      type: "get",
      url: "/api/get-option-post",
      data: {
        idCat: idCat,
      },
      success: function (result) {
        var re = JSON.parse(result);
        if (re.status == "FALSE") {
          x("#idPostHelp").addClass("error").html(re.message);
          x("#spanIdPost > span > span > .select2-selection")
            .removeClass("border-success")
            .addClass("border-danger");
          x("#idPost")
            .addClass("is-invalid")
            .removeClass("is-valid")
            .html(re.result);
        } else {
          x("#idPostHelp").removeClass("error").html(re.message);
          x("#spanIdPost > span > span > .select2-selection")
            .removeClass("border-danger")
            .addClass("border-success");
          x("#idPost").html(re.result);
        }
      },
      error: function (XMLHttpRequest, textStatus, errorThrown) {
        console.log("Status: " + textStatus);
        alert("Error: " + errorThrown);
      },
    });
  }
  function getFile() {
    var input, file;
    if (window.FileReader) {
      input = document.getElementById("filetailieu");
      if (!input) {
        return null;
        //    bodyAppend("p", "Um, couldn't find the fileinput element.");
      } else if (!input.files) {
        return null;
        //     bodyAppend("p", "This browser doesn't seem to support the `files` property of file inputs.");
      } else {
        return input.files[0];
      }
    }
  }
  function checkFile() {
    var file = getFile();
    x.ajax({
      type: "get",
      url: "/api/check-file",
      data: {
        name: file.name,
        size: file.size,
      },
      success: function (result) {
        var re = JSON.parse(result);
        if (re.status == "FALSE") {
          x("#filetailieu").removeClass("is-valid").addClass("is-invalid");
          x("#fileHelp").addClass("error").html(re.message);
          x("[for=filetailieu]").html(re.result);
        } else {
          x("#filetailieu").removeClass("is-invalid").addClass("is-valid");
          x("#fileHelp").removeClass("error").html(re.message);
          x("[for=filetailieu]").html(re.result);
        }
      },
      error: function (XMLHttpRequest, textStatus, errorThrown) {
        console.log("Status: " + textStatus);
        alert("Error: " + errorThrown);
      },
    });
  }
  function getInfoFile(button, idFile) {
    var btnold = loadBtn(button);
    var re = JSON.parse('{"status": "FALSE","message": "", "result": {}}');
    x.ajax({
      type: "get",
      url: "/api/get-info-file",
      data: {
        id: idFile,
      },
      success: function (result) {
        oldBtn(button, btnold);
        re = JSON.parse(result);
        x("#filetailieu").removeAttr("required");
        x("#filetailieu")
          .removeClass("is-invalid")
          .addClass("is-valid")
          .val("");
        x("#fileHelp").removeClass("error").html("");
        x("[for=filetailieu]").html(re.message);
      },
      error: function (XMLHttpRequest, textStatus, errorThrown) {
        console.log("Status: " + textStatus);
        console.log("Error: " + errorThrown);
        return re;
      },
    });
  }
  function deletefile() {
    var id = x("#title").attr("idFile");
    x.ajax({
      type: "post",
      url: "/quanly/tailieu/" + id + "/xoa",
      success: function (result) {
        x("button[data-dismiss=modal]").click();
        var re = JSON.parse(result);
        location.replace(re.url);
      },
    });
  }
  function deletefileid(id) {
    x.ajax({
      type: "post",
      url: "/quanly/tailieu/" + id + "/xoa",
      success: function (result) {
        x("button[data-dismiss=modal]").click();
        var re = JSON.parse(result);
        location.replace(re.url);
      },
    });
  }
});

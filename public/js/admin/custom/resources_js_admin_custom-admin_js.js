(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_admin_custom-admin_js"],{

/***/ "./resources/js/admin/custom-admin.js":
/*!********************************************!*\
  !*** ./resources/js/admin/custom-admin.js ***!
  \********************************************/
/***/ (() => {

function _createForOfIteratorHelper(o, allowArrayLike) { var it = typeof Symbol !== "undefined" && o[Symbol.iterator] || o["@@iterator"]; if (!it) { if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") { if (it) o = it; var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e) { throw _e; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var normalCompletion = true, didErr = false, err; return { s: function s() { it = it.call(o); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e2) { didErr = true; err = _e2; }, f: function f() { try { if (!normalCompletion && it["return"] != null) it["return"](); } finally { if (didErr) throw err; } } }; }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

$(document).ready(function () {
  var pagibtn = document.getElementsByClassName('pagi-number');
  $('.pagination-custom a').on('click', function (e) {
    e.preventDefault();
    var page = $(this).attr('href').split('page=')[1];
    getPosts(page);
  });

  function getPosts(page) {
    $.ajax({
      type: "GET",
      url: '?page=' + page,
      success: function success(data) {
        $("#test-body").innerHTML(data);
      }
    });
  } // change img product


  var oldSrcImgProduct = document.getElementById('product-img-admin');

  if (oldSrcImgProduct) {
    var _oldSrcImgProductVal = oldSrcImgProduct.src;
  }

  var btnChangeImgProduct = document.getElementById('label-change-avatar-product');
  var imgFileProduct = document.getElementById('img-file-product-admin');

  if (btnChangeImgProduct) {
    var oldFileProduct = imgFileProduct.files;

    btnChangeImgProduct.onclick = function () {
      var imgSrc = document.getElementById('img-file-product-admin');
      var oldFile = imgSrc.files;
      imgSrc.addEventListener('change', function () {
        var file = this.files[0];
        console.log(this.files.length);
        var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;

        if (!allowedExtensions.exec(file.name)) {
          document.getElementById('product-img-admin').src = oldSrcImgProductVal;
          this.files = oldFileProduct;
        } else if (file) {
          var reader = new FileReader();

          reader.onload = function () {
            var img = document.getElementById('product-img-admin');
            img.src = this.result;
          };

          reader.readAsDataURL(file);
        }
      });
    };
  } // change avatar admin


  if (document.getElementById('avatar-admin-id')) {
    var _oldSrcImgAvatarAdmin = document.getElementById('avatar-admin-id').src;
  }

  var btnChangeAvatar = document.getElementById('label-change-avatar');
  var imgSrc = document.getElementById('avatar-admin');

  if (imgSrc) {
    var _oldFile = imgSrc.files;
  }

  if (btnChangeAvatar) {
    var btnCancel = document.getElementsByClassName('cancel-avatar')[0];

    btnChangeAvatar.onclick = function () {
      imgSrc.addEventListener('change', function () {
        var file = this.files[0];
        console.log(file);
        var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;

        if (!allowedExtensions.exec(file.name)) {
          document.getElementById('avatar-admin-id').src = oldSrcImgAvatarAdmin;
          this.files = oldFile;
        } else if (file) {
          var reader = new FileReader();

          reader.onload = function () {
            var img = document.getElementById('avatar-admin-id');
            img.src = this.result;
          };

          reader.readAsDataURL(file);
        }
      });
    };

    btnCancel.onclick = function () {
      document.getElementById('avatar-admin-id').src = oldSrcImgAvatarAdmin;
      imgSrc.files = oldFile;
    };
  }

  var btnChangeSubimg = document.getElementById('btn-add-subimg');

  if (btnChangeSubimg) {
    btnChangeSubimg.onclick = function () {
      var divShow = document.getElementById('contain-subimg-add');
      var count = divShow.children.length + 1;
      var count2 = count - 1;
      var fileSubImgCheck = document.getElementById('sub-img-no-' + count2); // kiểm tra nếu inputfile bị khởi tạo nhưng không add thì xóa bỏ cái input đó đi

      if (fileSubImgCheck !== null && fileSubImgCheck.value.length == 0) {
        console.log(divShow.children[divShow.children.length - 1]);
        divShow.children[divShow.children.length - 1].remove();
      }

      count = divShow.children.length + 1;
      var html = "<div class=\"img-item item\" style=\"margin-right: 15px; cursor: pointer;\">\n                        <label for=\"sub-img-no-" + count + "\" id=\"label-change-subimg-" + count + "\" class=\"label-change-subimg-add\">\n                            <input class=\"form-control\" type=\"file\" name=\"sub_img[no" + count + "]\"\n                                accept=\"image/*\" id=\"sub-img-no-" + count + "\"\n                                style=\"position: absolute; left: -9999px;\">\n                        </label>\n                    </div>";
      divShow.insertAdjacentHTML('beforeend', html);
      var labelChange2 = document.getElementById('label-change-subimg-' + count + '');
      labelChange2.click();
      var fileSubImg = document.getElementById('sub-img-no-' + count);
      fileSubImg.addEventListener('change', function () {
        if (!labelChange2.children[1]) {
          labelChange2.insertAdjacentHTML('beforeend', "<img id=\"sub-img-admin-no-" + count + "\" style=\"height: 100%; width: 136px; cursor: pointer;\" src=\"\" alt=\"\">");
        }

        var file = this.files[0];
        var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;

        if (!allowedExtensions.exec(file.name)) {// document.getElementById('avatar-admin-id').src = oldSrcImgAvatarAdmin;
          // this.files = oldFile;
        } else if (file) {
          var reader = new FileReader();

          reader.onload = function () {
            var img = document.getElementById('sub-img-admin-no-' + count);
            img.src = this.result;
          };

          reader.readAsDataURL(file);
        }
      });
    };
  }

  ;
  var labelsChange = document.getElementsByClassName('label-change-subimg');

  var _iterator = _createForOfIteratorHelper(labelsChange),
      _step;

  try {
    for (_iterator.s(); !(_step = _iterator.n()).done;) {
      var labelChange = _step.value;

      labelChange.onclick = function () {
        console.log('vo day');
        var fileInput = this.children[0];
        var img = this.children[1];
        fileInput.addEventListener('change', function () {
          var file = this.files[0];
          console.log(file);
          var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;

          if (!allowedExtensions.exec(file.name)) {// document.getElementById('avatar-admin-id').src = oldSrcImgAvatarAdmin;
            // this.files = oldFile;
          } else if (file) {
            var reader = new FileReader();

            reader.onload = function () {
              if (img) {
                img.src = this.result;
              }
            };

            reader.readAsDataURL(file);
          }
        });
      };
    } // screen amount min max

  } catch (err) {
    _iterator.e(err);
  } finally {
    _iterator.f();
  }

  var amounts = document.getElementsByClassName('amount-size-admin');

  var _iterator2 = _createForOfIteratorHelper(amounts),
      _step2;

  try {
    for (_iterator2.s(); !(_step2 = _iterator2.n()).done;) {
      var amount = _step2.value;

      amount.oninput = function () {
        var min = parseInt(this.min);

        if (parseInt(this.value) < min) {
          this.value = min;
        }

        ;
      };
    } // delete action

  } catch (err) {
    _iterator2.e(err);
  } finally {
    _iterator2.f();
  }

  var btns = document.getElementsByClassName('btn-delete-product-instock');

  var _iterator3 = _createForOfIteratorHelper(btns),
      _step3;

  try {
    var _loop = function _loop() {
      var btn = _step3.value;

      btn.onclick = function () {
        var form = btn.parentElement;
        Swal.fire({
          title: 'Are you sure?',
          text: "Product is instock, you still want to delete this product",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then(function (result) {
          if (result.isConfirmed) {
            form.submit();
          }
        });
      };
    };

    for (_iterator3.s(); !(_step3 = _iterator3.n()).done;) {
      _loop();
    } //change avatar shop

  } catch (err) {
    _iterator3.e(err);
  } finally {
    _iterator3.f();
  }

  var oldSrcImgShop = document.getElementById('shop-img-admin');

  if (oldSrcImgShop) {
    var oldSrcImgShopVal = oldSrcImgShop.src;
    var btnChangeImgUser = document.getElementById('label-change-avatar-shop');
    var imgFileShop = document.getElementById('img-file-shop-admin');

    if (btnChangeImgUser) {
      var oldFileUser = imgFileShop.files;

      btnChangeImgUser.onclick = function () {
        var imgSrc = document.getElementById('img-file-user-admin');
        var oldFile = imgSrc.files;
        imgSrc.addEventListener('change', function () {
          var file = this.files[0];
          console.log(this.files.length);
          var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;

          if (!allowedExtensions.exec(file.name)) {
            document.getElementById('shop-img-admin').src = oldSrcImgShopVal;
            this.files = oldFileUser;
          } else if (file) {
            var reader = new FileReader();

            reader.onload = function () {
              var img = document.getElementById('shop-img-admin');
              img.src = this.result;
            };

            reader.readAsDataURL(file);
          }
        });
      };
    }
  } // change avatar user


  var oldSrcImgUser = document.getElementById('user-img-admin');

  if (oldSrcImgUser) {
    var oldSrcImgUserVal = oldSrcImgUser.src;

    var _btnChangeImgUser = document.getElementById('label-change-avatar-user');

    var imgFileUser = document.getElementById('img-file-user-admin');

    if (_btnChangeImgUser) {
      var _oldFileUser = imgFileUser.files;

      _btnChangeImgUser.onclick = function () {
        var imgSrc = document.getElementById('img-file-user-admin');
        var oldFile = imgSrc.files;
        imgSrc.addEventListener('change', function () {
          var file = this.files[0];
          console.log(this.files.length);
          var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;

          if (!allowedExtensions.exec(file.name)) {
            document.getElementById('user-img-admin').src = oldSrcImgUserVal;
            this.files = oldFile;
          } else if (file) {
            var reader = new FileReader();

            reader.onload = function () {
              var img = document.getElementById('user-img-admin');
              img.src = this.result;
            };

            reader.readAsDataURL(file);
          }
        });
      };
    }
  } // carousel


  $('.owl-carousel').owlCarousel({
    loop: false,
    margin: 10,
    nav: true,
    dots: false,
    responsive: {
      0: {
        items: 1
      },
      600: {
        items: 1
      },
      1000: {
        items: 3
      }
    }
  });
  var modalShow = document.getElementById('modal-add-address');

  if (modalShow && modalShow.classList.contains("message-error")) {
    console.log(modalShow);
    console.log($("#modal-add-address"));
    $("#modal-add-address").modal();
  }

  var modalShowRole = document.getElementById('modal-add-role');

  if (modalShowRole && modalShowRole.classList.contains("message-error")) {
    console.log('vao day');
    $("#modal-add-role").modal();
  } /////////////////////////////


  var btnsChangeStatus = document.getElementsByClassName('btn-change-status-user');

  var _iterator4 = _createForOfIteratorHelper(btnsChangeStatus),
      _step4;

  try {
    var _loop2 = function _loop2() {
      var btnChangeStatus = _step4.value;

      btnChangeStatus.onclick = function () {
        var form = btnChangeStatus.parentElement;
        Swal.fire({
          title: 'Are you sure?',
          text: "You will change now status",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes'
        }).then(function (result) {
          if (result.isConfirmed) {
            form.submit();
          }
        });
      };
    };

    for (_iterator4.s(); !(_step4 = _iterator4.n()).done;) {
      _loop2();
    }
  } catch (err) {
    _iterator4.e(err);
  } finally {
    _iterator4.f();
  }

  $('.select-custom').select2();
  $("select").select2("readonly", true);
});
var keyInput = document.getElementById("key-name-search");

if (keyInput) {
  keyInput.onkeyup = function (e) {
    e.preventDefault();
    var key = this.value;
    var link = this.getAttribute("data-link");
    var data = {
      "key-name": key
    };
    $.ajax({
      url: link,
      type: 'GET',
      data: data,
      success: function success(result) {
        $('body').html(result);
        document.getElementById("key-name-search").textContent = key;
        document.getElementById("key-name-search").value = key;
      }
    });
  };
}

/***/ })

}]);
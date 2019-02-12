webpackJsonp([1],{

/***/ 46:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(1)
/* script */
var __vue_script__ = __webpack_require__(47)
/* template */
var __vue_template__ = __webpack_require__(48)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "resources/assets/js/pages/Register.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-0f409c60", Component.options)
  } else {
    hotAPI.reload("data-v-0f409c60", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 47:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
  data: function data() {
    return {
      name: '',
      email: '',
      password: '',
      password_confirmation: ''
    };
  },

  methods: {
    register: function register() {
      var _this = this;

      this.$validator.validateAll().then(function (result) {
        if (result) {
          var data = {
            name: _this.name,
            email: _this.email,
            password: _this.password,
            password_confirmation: _this.password_confirmation
          };
          axios.post('/api/register', data).then(function (_ref) {
            var data = _ref.data;

            alert(data.message);
          }).catch(function (_ref2) {
            var response = _ref2.response;

            alert(response.data.message);
          });
          return;
        }
        alert('errors');
      });
    }
  }
});

/***/ }),

/***/ 48:
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "container" }, [
    _c("div", { staticClass: "row" }, [
      _c("div", { staticClass: "col-md-8 col-md-offset-2" }, [
        _c("h2", [_vm._v("Register")]),
        _vm._v(" "),
        _c("div", { staticClass: "form-group" }, [
          _c("label", [_vm._v("Name")]),
          _vm._v(" "),
          _c("input", {
            directives: [
              {
                name: "validate",
                rawName: "v-validate",
                value: "required",
                expression: "'required'"
              },
              {
                name: "model",
                rawName: "v-model",
                value: _vm.name,
                expression: "name"
              }
            ],
            staticClass: "form-control",
            attrs: { type: "name", name: "name", placeholder: "Enter name" },
            domProps: { value: _vm.name },
            on: {
              input: function($event) {
                if ($event.target.composing) {
                  return
                }
                _vm.name = $event.target.value
              }
            }
          }),
          _vm._v(" "),
          _c(
            "span",
            {
              directives: [
                {
                  name: "show",
                  rawName: "v-show",
                  value: _vm.errors.has("name"),
                  expression: "errors.has('name')"
                }
              ],
              staticClass: "help is-danger"
            },
            [_vm._v(_vm._s(_vm.errors.first("name")))]
          )
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "form-group" }, [
          _c("label", { attrs: { for: "email" } }, [_vm._v("Email address")]),
          _vm._v(" "),
          _c("input", {
            directives: [
              {
                name: "validate",
                rawName: "v-validate",
                value: "required|email",
                expression: "'required|email'"
              },
              {
                name: "model",
                rawName: "v-model",
                value: _vm.email,
                expression: "email"
              }
            ],
            staticClass: "form-control",
            class: { "is-danger": _vm.errors.has("email") },
            attrs: {
              type: "email",
              name: "email",
              id: "email",
              placeholder: "Enter email"
            },
            domProps: { value: _vm.email },
            on: {
              input: function($event) {
                if ($event.target.composing) {
                  return
                }
                _vm.email = $event.target.value
              }
            }
          }),
          _vm._v(" "),
          _c(
            "span",
            {
              directives: [
                {
                  name: "show",
                  rawName: "v-show",
                  value: _vm.errors.has("email"),
                  expression: "errors.has('email')"
                }
              ],
              staticClass: "help is-danger"
            },
            [_vm._v(_vm._s(_vm.errors.first("email")))]
          )
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "form-group" }, [
          _c("label", [_vm._v("Password")]),
          _vm._v(" "),
          _c("input", {
            directives: [
              {
                name: "model",
                rawName: "v-model",
                value: _vm.password,
                expression: "password"
              },
              {
                name: "validate",
                rawName: "v-validate",
                value: "required|min:6",
                expression: "'required|min:6'"
              }
            ],
            staticClass: "form-control",
            attrs: {
              type: "password",
              name: "password",
              placeholder: "Password"
            },
            domProps: { value: _vm.password },
            on: {
              input: function($event) {
                if ($event.target.composing) {
                  return
                }
                _vm.password = $event.target.value
              }
            }
          }),
          _vm._v(" "),
          _c(
            "span",
            {
              directives: [
                {
                  name: "show",
                  rawName: "v-show",
                  value: _vm.errors.has("password"),
                  expression: "errors.has('password')"
                }
              ],
              staticClass: "help is-danger"
            },
            [_vm._v(_vm._s(_vm.errors.first("password")))]
          )
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "form-group" }, [
          _c("label", { attrs: { for: "c_password" } }, [
            _vm._v("Confirm Password")
          ]),
          _vm._v(" "),
          _c("input", {
            directives: [
              {
                name: "model",
                rawName: "v-model",
                value: _vm.password_confirmation,
                expression: "password_confirmation"
              }
            ],
            staticClass: "form-control",
            attrs: {
              type: "password",
              id: "c_password",
              placeholder: "Confirm Password"
            },
            domProps: { value: _vm.password_confirmation },
            on: {
              input: function($event) {
                if ($event.target.composing) {
                  return
                }
                _vm.password_confirmation = $event.target.value
              }
            }
          }),
          _vm._v(" "),
          _c(
            "span",
            {
              directives: [
                {
                  name: "show",
                  rawName: "v-show",
                  value: _vm.errors.has("password"),
                  expression: "errors.has('password')"
                }
              ],
              staticClass: "help is-danger"
            },
            [_vm._v(_vm._s(_vm.errors.first("password")))]
          )
        ]),
        _vm._v(" "),
        _c(
          "button",
          {
            staticClass: "btn btn-primary",
            on: {
              click: function($event) {
                $event.preventDefault()
                return _vm.register($event)
              }
            }
          },
          [_vm._v("Register")]
        )
      ])
    ])
  ])
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-0f409c60", module.exports)
  }
}

/***/ })

});
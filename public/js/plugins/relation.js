/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/plugins/relation.js":
/*!******************************************!*\
  !*** ./resources/js/plugins/relation.js ***!
  \******************************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function ($) {
  $.fn.extend({
    relation: function relation(options) {
      var _this = this;

      this.settings = $.extend({}, options);
      /* ===== Function List =====*/

      var init = {
        initVar: function initVar() {
          _this.settings.data = JSON.parse(_this.settings.data);
          relation.setOptionNotRegistered();
          relation.setOptionRegistered();
          init.setHtmlPure();
        },
        setHtmlPure: function setHtmlPure() {
          txt = "";

          for (key in _this.settings.data.all) {
            txt += "<option value=" + key + ">" + _this.settings.data.all[key] + "</option>";
          }

          _this.settings.allHtml = txt;
        }
      };
      var relation = {
        setOptionRegistered: function setOptionRegistered() {
          txt = "";

          if (_this.settings.data.selected) {
            for (key in _this.settings.data.selected) {
              if (_this.settings.data.selected[key]) {
                txt += "<option value=" + key + ">" + _this.settings.data.selected[key].replace(/\}/g, '\'') + "</option>";
              }
            }

            $(_this).find(".registered").html(txt);
          }
        },
        setOptionNotRegistered: function setOptionNotRegistered() {
          txt = "";

          if (_this.settings.data.notSelected) {
            for (key in _this.settings.data.notSelected) {
              if (_this.settings.data.notSelected[key]) {
                txt += "<option value=" + key + ">" + _this.settings.data.notSelected[key].replace(/\}/g, '\'') + "</option>";
              }
            }

            $(_this).find(".notregistered").html(txt);
          }
        },
        moveUnselect: function moveUnselect(type) {
          if (type == 'all') $(_this).find(".notregistered option").appendTo(".registered");else $(_this).find(".notregistered option:selected").appendTo(".registered");
        },
        moveSelected: function moveSelected() {
          $(_this).find(".registered option:selected").appendTo(".notregistered");
        },
        clearAll: function clearAll() {
          $(_this).find(".registered").html('');
          $(_this).find(".notregistered").html(_this.settings.allHtml);
        },
        reset: function reset() {
          relation.setOptionNotRegistered();
          relation.setOptionRegistered();
        },
        submit: function submit() {
          $(_this).find(".registered option").attr("selected", "selected");
          $(_this).find(".regform").submit();
        }
      };
      /* ===== Action List =====*/

      $(this).find(".next").click(function () {
        relation.moveUnselect('partial');
      });
      $(this).find(".moveall").click(function () {
        relation.moveUnselect('all');
      });
      $(this).find(".reset").click(function () {
        relation.reset();
      });
      $(this).find(".clear_all").click(function () {
        relation.clearAll();
      });
      $(this).find(".remove_registered").click(function () {
        relation.moveSelected();
      });
      $(this).find(".btnSaveChanges").click(function (e) {
        e.preventDefault();
        relation.submit();
      });
      /* ===== Init List =====*/

      init.initVar();
    }
  });
})(jQuery);

/***/ }),

/***/ 1:
/*!************************************************!*\
  !*** multi ./resources/js/plugins/relation.js ***!
  \************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /var/www/html/ours/resources/js/plugins/relation.js */"./resources/js/plugins/relation.js");


/***/ })

/******/ });
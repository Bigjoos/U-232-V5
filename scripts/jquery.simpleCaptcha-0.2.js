/* Copyright (c) 2009 Jordan Kasper
 * Licensed under the MIT (http://www.opensource.org/licenses/mit-license.php)
 * Copyright notice and license must remain intact for legal use
 * Requires: jQuery 1.2+
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, 
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF 
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND 
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS 
 * BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN 
 * ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN 
 * CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 * 
 * Fore usage documentation and examples, visit:
 *         http://jkdesign.org/captcha/
 * 
 * TODO:
 *   Full testing suite
 * 
 * REVISIONS:
 *   0.1 Initial release
 *   0.2 Changed to use title attribute of image for hash (versus alt)
 *       (We don't want the hash showing as images load)
 *       Fixed simpleCaptcha.php to return properly formatted JSON (fixes bug in jQuery 1.4)
 * 
 */
;(function($) {
  
  $.fn.simpleCaptcha = function(o) {
    var n = this;
    if (n.length < 1) { return n; }
    
    o = (o)?o:{};
    o = auditOptions($.extend({}, $.fn.simpleCaptcha.defaults, o));
    
    var inputId = "simpleCaptcha_"+($.fn.simpleCaptcha.uid++);
    n
      .addClass('simpleCaptcha')
      .html('')  // clear out the container
      .append(
        "<div class='"+o.introClass+"'>"+o.introText+"</div>"+
        "<div class='"+o.imageBoxClass+"'></div>"+
        "<input class='simpleCaptchaInput' id='"+inputId+"' name='"+o.inputName+"' type='hidden' value='' />"
      );
    
    // Call simpleCaptcha.php to get images and current selection
    $.ajax({
      url: o.scriptPath,
      data: { numImages: o.numImages },
      method: 'post',
      dataType: 'json',
      success: function(data, status) {
        if (typeof data.error == 'string') {
          handleError(n, data.error);
          return;
        } else {
          // Add image text to correct place
          n.find('.'+o.textClass).html(data.text);
          
          // Add images to container with click handlers
          var imgBox = n.find('.'+o.imageBoxClass);
          $.each(data.images, function() {
            imgBox.append("<img class='"+o.imageClass+"' src='"+this.file+"' alt='' title='"+this.hash+"' />");
          });
          imgBox.find('img.'+o.imageClass)
            .click(function(e) {
              n.find('img.'+o.imageClass).removeClass('simpleCaptchaSelected');
              var hash = $(this).addClass('simpleCaptchaSelected').attr('title');
              $('#'+inputId).val(hash);
              n.trigger('select.simpleCaptcha', [hash]);
              return false;
            })
            .keyup(function(e) {
              if (e.keyCode == 13 || e.which == 13) {
                $(this).click();
              }
            });
          n.trigger('loaded.simpleCaptcha', [data]);
        }
      },
      error: function(xhr, status) {
        handleError(n, 'There was a serious problem: '+xhr.status);
      }
    });
    
    return n;  // Continue jQuery chain
  };
  
  var handleError = function(n, msg) {
    n.trigger('error.simpleCaptcha', [msg]);
  }
  
  // Defined outside simpleCaptcha to allow for usage during construction
  var auditOptions = function(o) {
    if (typeof o.numImages != 'number' || o.numImages < 1) { o.numImages = $.fn.simpleCaptcha.defaults.numImages; }
    if (typeof o.introText != 'string' || o.introText.length < 1) { o.introText = $.fn.simpleCaptcha.defaults.introText; }
    if (typeof o.inputName != 'string') { o.inputName = $.fn.simpleCaptcha.defaults.inputName; }
    if (typeof o.scriptPath != 'string') { o.scriptPath = $.fn.simpleCaptcha.defaults.scriptPath; }
    if (typeof o.introClass != 'string') { o.introClass = $.fn.simpleCaptcha.defaults.introClass; }
    if (typeof o.textClass != 'string') { o.textClass = $.fn.simpleCaptcha.defaults.textClass; }
    if (typeof o.imageBoxClass != 'string') { o.imageBoxClass = $.fn.simpleCaptcha.defaults.imageBoxClass; }
    if (typeof o.imageClass != 'string') { o.imageClass = $.fn.simpleCaptcha.defaults.imageClass; }
    
    return o;
  }
  
  $.fn.simpleCaptcha.uid = 0;
  
  // options for simpleCaptcha instances...
  $.fn.simpleCaptcha.defaults = {
    numImages: 5,                     // Number How many images to show the user (providing there are at least that many defined in the script file).
    introText: "<p align='center'>To make sure you are a human, we need you to click on the <span class='captchaText'></span>.</p>",
                                      // String Text to place above captcha images (can contain html). IMPORTANT: You should probably include a tag with the textClass name on it, for example: <span id='captchaText'></span>
    inputName: 'captchaSelection',    // String Name to use for the captcha hidden input, this is what you will need to check on the receiving end of the form submission.
    scriptPath: 'simpleCaptcha.php',  // String Relative path to the script file to use (usually simpleCaptcha.php).
    introClass: 'captchaIntro',       // String Class to use for the captcha introduction text container.
    textClass: 'captchaText',         // String Class to look for to place the text for the correct captcha image.
    imageBoxClass: 'captchaImages',   // String Class to use for the captchas images container.
    imageClass: 'captchaImage'        // String Class to use for each captcha image.
  };

})(jQuery);
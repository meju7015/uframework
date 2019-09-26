/**
 * jquery �� ������� �ʰų� �������� �ʴ� ��Ȳ���� ����ϱ����� ���̺귯��
 * @type {{xhr: *, post: request.post, get: request.get, url: *}}
 */
const request = {
    url: URL.HOME_INDEX,
    xhr: new XMLHttpRequest(),
    get: function(options, success, done, error) {
        var _this = this;

        _this.xhr.open('GET', encodeURI(_this.url));
        _this.xhr.onreadyStatechange = function() {
            if (_this.xhr.readyState === 4 && _this.xhr.status === 200) {
                return success;
            } else {
                return error;
            }
        }
    },
    post: function(options, success, done, error) {
        var _this = this;

        _this.xhr.open('POST', encodeURI(_this.url));
        _this.xhr.oneadyStatechange = function() {
            if (_this.xhr.readyState === 4 && _this.xhr.status === 200) {
                return success;
            } else {
                return error;
            }
        }
    }
};
require('jquery-query-object');
export default function (key, val, action = location.pathname, domain = location.origin, pageName = 'page') {
    if (key) {
        if ($.isArray(key)) {
            key.forEach((item, index) => {
                if (item === null) {
                    $.query.REMOVE(index);
                } else {
                    $.query.SET(item, val === null ? val : val[index]);
                }
            });
        } else {
            $.query.SET(key, val);
        }
    }
    if (pageName) {
        $.query.REMOVE(pageName);
    }
    return domain + action + $.query.toString();
};

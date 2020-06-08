class Router {
    constructor(links, useAbsolutePath = true, defaultHost = '') {
        this.defaultHost = defaultHost;
        this.links = links;
        this.useAbsolutePath = useAbsolutePath;
    }
    route(routeName, params = {}) {
        let result = this.links[routeName];

        if (!routeName || !result) {
            return '';
        }

        for (let key in params) {
            if (params.hasOwnProperty(key)) {
                if (Array.isArray(params)) {
                    result = result.replace(/{([^}]*)}/, params[key]);
                } else {
                    result = result.replace('{' + key + '}', params[key]);
                }
            }
        }

        // Remove remaining parameters if they exist
        let parameter = result.match(/\/{([^}]*)}/);
        while (parameter) {
            result = result.replace(parameter[0], '');

            parameter = result.match(/\/{([^}]*)}/);
        }

        if (this.useAbsolutePath) {
            result = this.defaultHost + result;
        }
        return result;
    }

    path(routeName) {
        let result = this.links[routeName];

        if (!routeName || !result) {
            return '';
        }

        let parameter = result.match(/{([^}]*)}/);
        while (parameter) {
            result = result.replace(parameter[0], ':' + parameter[1]);

            parameter = result.match(/{([^}]*)}/);
        }

        return result;
    }
}

export default Router;
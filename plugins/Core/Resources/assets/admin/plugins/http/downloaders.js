import axios from "axios/index";

export default (http, store, router) => {
    http['download'] = (url, file, name) => {
        axios({
            url: 'api/' + url,
            method: 'POST',
            responseType: 'blob', // important
            data: {
                path: file
            }
        }).then((response) => {
            const url = window.URL.createObjectURL(new Blob([response.data]));
            const link = document.createElement('a');
            link.href = url;
            link.setAttribute('download', name);
            document.body.appendChild(link);
            link.click();
            store.dispatch('setFetching', {fetching: false});
            store.dispatch('resetMessages');
        });
    };
}
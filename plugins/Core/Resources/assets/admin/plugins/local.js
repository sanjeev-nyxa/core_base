/* eslint-disable no-undef */
export function localStorageSetItem(label, obj) {
    localStorage.setItem(label, JSON.stringify(obj))
}

export function localStorageGetItem(label) {
    const string = localStorage.getItem(label)
    return (string && string != 'undefined') ? JSON.parse(string) : null;
}

import auth from './+auth';
import home from './+home';
import accounts from './+accounts';
import settings from './+settings';
import translations from './+translations';

// https://developer.mozilla.org/pt-BR/docs/Web/JavaScript/Reference/Operators/Spread_operator
// Thus a new array is created, containing all objects that match the routes.
// ...dashboard must be the last one because of the catchall instruction
const Routes = [
    ...auth,
    ...home,
    ...accounts,
    ...settings,
    ...translations
];

Routes.map(route => {
    Zexus.routes.push(route)
});
import Router from './Router';

const webRouter = new Router({
    frontpage: '/',
    pageNew: '/new',

    post: '/p/{sluggedId}',

    user: '/u/{sluggedId}/{info?}/{subInfo?}',

    category: '/{category}',
    categories: '/categories',

    tag: '/tags/{tag}',
    tags: '/tags',

}, false);

export default webRouter;
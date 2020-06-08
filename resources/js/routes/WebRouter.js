import Router from './Router';

const webRouter = new Router({
    frontpage: '/',
    pageNew: '/new',
    post: '/p/{sluggedId}',
    user: '/u/{sluggedId}/{info?}/{subInfo?}',
    tag: '/tag/{tag}',
    category: '/{category}',
    categories: '/categories',
    tags: '/tags',

}, false);

export default webRouter;
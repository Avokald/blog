import Router from './Router';

const apiRouter = new Router({
    frontpage:  '/api/v1/page/frontpage/',
    pageNew: '/api/v1/page/new/',
    post: '/api/v1/post/{postId}',
    user: '/api/v1/user/{userId}/',
    category: '/api/v1/category/{categorySlug}',
    users: '/api/v1/misc/users',
    categories: '/api/v1/misc/categories',
    tags: '/api/v1/misc/tags',
}, true, process.env.MIX_APP_API_HOST);

export default apiRouter;
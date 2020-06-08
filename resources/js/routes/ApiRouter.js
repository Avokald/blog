import Router from './Router';

const apiRouter = new Router({
    frontpage:  '/api/v1/page/frontpage/',
    newPosts: '/api/v1/page/new/',
    post: '/api/v1/post/{postId}',
    user: '/api/v1/user/{userId}/',
    category: '/api/v1/category/{categorySlug}',
}, true, process.env.MIX_APP_API_HOST);

export default apiRouter;
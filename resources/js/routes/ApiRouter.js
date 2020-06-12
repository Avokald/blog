import Router from './Router';

const apiRouter = new Router({
    metadata: '/api/v1/metadata',

    frontpage:  '/api/v1/page/frontpage/',
    pageNew: '/api/v1/page/new/',
    post: '/api/v1/post/{postId}',

    user: '/api/v1/user/{userId}/',
    userComments: '/api/v1/user/{userId}/comments',
    userDrafts: '/api/v1/user/{userId}/drafts',
    userBookmarkPosts: '/api/v1/user/{userId}/bookmarks/posts',
    users: '/api/v1/misc/users',

    userBookmarkComments: '/api/v1/user/{userId}/bookmarks/comments',
    category: '/api/v1/category/{categorySlug}',
    categories: '/api/v1/misc/categories',

    tag: '/api/v1/tags/{tag}',
    tags: '/api/v1/misc/tags',
}, true, process.env.MIX_APP_API_HOST);

export default apiRouter;
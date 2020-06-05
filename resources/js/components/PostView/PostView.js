import React, {Component} from 'react';
import {connect} from 'react-redux';

class PostView extends Component {
    constructor(props) {
      super(props);
      this.comments = [
            {
                "id": 13,
                "content": "13",
                "user_id": 2,
                "post_id": 1,
                "reply_id": null,
                "parent_1_id": null,
                "parent_2_id": null,
                "parent_3_id": null,
                "created_at": "2020-05-31 18:53:35",
                "updated_at": "2020-05-31 18:53:35",
                "author": {
                    "id": 2,
                    "name": "testuser",
                    "slug": "testuser",
                    "image": "https://lorempixel.com/120/120/?14081",
                    "banner": "https://lorempixel.com/640/160/?68438",
                    "description": "Quo adipisci est ut error aut molestiae provident id. Et asperiores nisi sunt vel nobis molestias quia. Neque pariatur qui doloremque autem temporibus mollitia.",
                    "pinned_post_id": 1,
                    "created_at": "2020-05-31 18:53:32",
                    "updated_at": "2020-05-31 18:53:32"
                }
            },
            {
                "id": 14,
                "content": "test comment content 1",
                "user_id": 2,
                "post_id": 1,
                "reply_id": null,
                "parent_1_id": null,
                "parent_2_id": null,
                "parent_3_id": null,
                "created_at": "2020-05-31 18:53:35",
                "updated_at": "2020-05-31 18:53:35",
                "author": {
                    "id": 2,
                    "name": "testuser",
                    "slug": "testuser",
                    "image": "https://lorempixel.com/120/120/?14081",
                    "banner": "https://lorempixel.com/640/160/?68438",
                    "description": "Quo adipisci est ut error aut molestiae provident id. Et asperiores nisi sunt vel nobis molestias quia. Neque pariatur qui doloremque autem temporibus mollitia.",
                    "pinned_post_id": 1,
                    "created_at": "2020-05-31 18:53:32",
                    "updated_at": "2020-05-31 18:53:32"
                }
            },
            {
                "id": 15,
                "content": "test comment content 2",
                "user_id": 2,
                "post_id": 1,
                "reply_id": null,
                "parent_1_id": null,
                "parent_2_id": null,
                "parent_3_id": null,
                "created_at": "2020-05-31 18:53:35",
                "updated_at": "2020-05-31 18:53:35",
                "author": {
                    "id": 2,
                    "name": "testuser",
                    "slug": "testuser",
                    "image": "https://lorempixel.com/120/120/?14081",
                    "banner": "https://lorempixel.com/640/160/?68438",
                    "description": "Quo adipisci est ut error aut molestiae provident id. Et asperiores nisi sunt vel nobis molestias quia. Neque pariatur qui doloremque autem temporibus mollitia.",
                    "pinned_post_id": 1,
                    "created_at": "2020-05-31 18:53:32",
                    "updated_at": "2020-05-31 18:53:32"
                }
            },
            {
                "id": 16,
                "content": "test comment content",
                "user_id": 2,
                "post_id": 1,
                "reply_id": null,
                "parent_1_id": null,
                "parent_2_id": null,
                "parent_3_id": null,
                "created_at": "2020-05-31 18:53:35",
                "updated_at": "2020-05-31 18:53:35",
                "author": {
                    "id": 2,
                    "name": "testuser",
                    "slug": "testuser",
                    "image": "https://lorempixel.com/120/120/?14081",
                    "banner": "https://lorempixel.com/640/160/?68438",
                    "description": "Quo adipisci est ut error aut molestiae provident id. Et asperiores nisi sunt vel nobis molestias quia. Neque pariatur qui doloremque autem temporibus mollitia.",
                    "pinned_post_id": 1,
                    "created_at": "2020-05-31 18:53:32",
                    "updated_at": "2020-05-31 18:53:32"
                }
            },
            {
                "id": 12,
                "content": "12",
                "user_id": 2,
                "post_id": 1,
                "reply_id": 8,
                "parent_1_id": 1,
                "parent_2_id": 2,
                "parent_3_id": 6,
                "created_at": "2020-05-31 18:38:45",
                "updated_at": "2020-05-31 18:53:35",
                "author": {
                    "id": 2,
                    "name": "testuser",
                    "slug": "testuser",
                    "image": "https://lorempixel.com/120/120/?14081",
                    "banner": "https://lorempixel.com/640/160/?68438",
                    "description": "Quo adipisci est ut error aut molestiae provident id. Et asperiores nisi sunt vel nobis molestias quia. Neque pariatur qui doloremque autem temporibus mollitia.",
                    "pinned_post_id": 1,
                    "created_at": "2020-05-31 18:53:32",
                    "updated_at": "2020-05-31 18:53:32"
                }
            },
            {
                "id": 11,
                "content": "11",
                "user_id": 2,
                "post_id": 1,
                "reply_id": 9,
                "parent_1_id": 1,
                "parent_2_id": 2,
                "parent_3_id": 6,
                "created_at": "2020-05-31 18:38:35",
                "updated_at": "2020-05-31 18:53:35",
                "author": {
                    "id": 2,
                    "name": "testuser",
                    "slug": "testuser",
                    "image": "https://lorempixel.com/120/120/?14081",
                    "banner": "https://lorempixel.com/640/160/?68438",
                    "description": "Quo adipisci est ut error aut molestiae provident id. Et asperiores nisi sunt vel nobis molestias quia. Neque pariatur qui doloremque autem temporibus mollitia.",
                    "pinned_post_id": 1,
                    "created_at": "2020-05-31 18:53:32",
                    "updated_at": "2020-05-31 18:53:32"
                }
            },
            {
                "id": 10,
                "content": "10",
                "user_id": 2,
                "post_id": 1,
                "reply_id": 6,
                "parent_1_id": 1,
                "parent_2_id": 2,
                "parent_3_id": 6,
                "created_at": "2020-05-31 18:38:25",
                "updated_at": "2020-05-31 18:53:35",
                "author": {
                    "id": 2,
                    "name": "testuser",
                    "slug": "testuser",
                    "image": "https://lorempixel.com/120/120/?14081",
                    "banner": "https://lorempixel.com/640/160/?68438",
                    "description": "Quo adipisci est ut error aut molestiae provident id. Et asperiores nisi sunt vel nobis molestias quia. Neque pariatur qui doloremque autem temporibus mollitia.",
                    "pinned_post_id": 1,
                    "created_at": "2020-05-31 18:53:32",
                    "updated_at": "2020-05-31 18:53:32"
                }
            },
            {
                "id": 9,
                "content": "9",
                "user_id": 2,
                "post_id": 1,
                "reply_id": 8,
                "parent_1_id": 1,
                "parent_2_id": 2,
                "parent_3_id": 6,
                "created_at": "2020-05-31 18:38:15",
                "updated_at": "2020-05-31 18:53:35",
                "author": {
                    "id": 2,
                    "name": "testuser",
                    "slug": "testuser",
                    "image": "https://lorempixel.com/120/120/?14081",
                    "banner": "https://lorempixel.com/640/160/?68438",
                    "description": "Quo adipisci est ut error aut molestiae provident id. Et asperiores nisi sunt vel nobis molestias quia. Neque pariatur qui doloremque autem temporibus mollitia.",
                    "pinned_post_id": 1,
                    "created_at": "2020-05-31 18:53:32",
                    "updated_at": "2020-05-31 18:53:32"
                }
            },
            {
                "id": 8,
                "content": "8",
                "user_id": 2,
                "post_id": 1,
                "reply_id": 6,
                "parent_1_id": 1,
                "parent_2_id": 2,
                "parent_3_id": null,
                "created_at": "2020-05-31 18:38:05",
                "updated_at": "2020-05-31 18:53:35",
                "author": {
                    "id": 2,
                    "name": "testuser",
                    "slug": "testuser",
                    "image": "https://lorempixel.com/120/120/?14081",
                    "banner": "https://lorempixel.com/640/160/?68438",
                    "description": "Quo adipisci est ut error aut molestiae provident id. Et asperiores nisi sunt vel nobis molestias quia. Neque pariatur qui doloremque autem temporibus mollitia.",
                    "pinned_post_id": 1,
                    "created_at": "2020-05-31 18:53:32",
                    "updated_at": "2020-05-31 18:53:32"
                }
            },
            {
                "id": 7,
                "content": "7",
                "user_id": 2,
                "post_id": 1,
                "reply_id": 2,
                "parent_1_id": 1,
                "parent_2_id": 2,
                "parent_3_id": null,
                "created_at": "2020-05-31 18:37:55",
                "updated_at": "2020-05-31 18:53:35",
                "author": {
                    "id": 2,
                    "name": "testuser",
                    "slug": "testuser",
                    "image": "https://lorempixel.com/120/120/?14081",
                    "banner": "https://lorempixel.com/640/160/?68438",
                    "description": "Quo adipisci est ut error aut molestiae provident id. Et asperiores nisi sunt vel nobis molestias quia. Neque pariatur qui doloremque autem temporibus mollitia.",
                    "pinned_post_id": 1,
                    "created_at": "2020-05-31 18:53:32",
                    "updated_at": "2020-05-31 18:53:32"
                }
            },
            {
                "id": 6,
                "content": "6",
                "user_id": 2,
                "post_id": 1,
                "reply_id": 2,
                "parent_1_id": 1,
                "parent_2_id": 2,
                "parent_3_id": null,
                "created_at": "2020-05-31 18:37:45",
                "updated_at": "2020-05-31 18:53:35",
                "author": {
                    "id": 2,
                    "name": "testuser",
                    "slug": "testuser",
                    "image": "https://lorempixel.com/120/120/?14081",
                    "banner": "https://lorempixel.com/640/160/?68438",
                    "description": "Quo adipisci est ut error aut molestiae provident id. Et asperiores nisi sunt vel nobis molestias quia. Neque pariatur qui doloremque autem temporibus mollitia.",
                    "pinned_post_id": 1,
                    "created_at": "2020-05-31 18:53:32",
                    "updated_at": "2020-05-31 18:53:32"
                }
            },
            {
                "id": 5,
                "content": "5",
                "user_id": 2,
                "post_id": 1,
                "reply_id": 1,
                "parent_1_id": 1,
                "parent_2_id": null,
                "parent_3_id": null,
                "created_at": "2020-05-31 18:37:35",
                "updated_at": "2020-05-31 18:53:35",
                "author": {
                    "id": 2,
                    "name": "testuser",
                    "slug": "testuser",
                    "image": "https://lorempixel.com/120/120/?14081",
                    "banner": "https://lorempixel.com/640/160/?68438",
                    "description": "Quo adipisci est ut error aut molestiae provident id. Et asperiores nisi sunt vel nobis molestias quia. Neque pariatur qui doloremque autem temporibus mollitia.",
                    "pinned_post_id": 1,
                    "created_at": "2020-05-31 18:53:32",
                    "updated_at": "2020-05-31 18:53:32"
                }
            },
            {
                "id": 4,
                "content": "4",
                "user_id": 2,
                "post_id": 1,
                "reply_id": 1,
                "parent_1_id": 1,
                "parent_2_id": null,
                "parent_3_id": null,
                "created_at": "2020-05-31 18:37:25",
                "updated_at": "2020-05-31 18:53:35",
                "author": {
                    "id": 2,
                    "name": "testuser",
                    "slug": "testuser",
                    "image": "https://lorempixel.com/120/120/?14081",
                    "banner": "https://lorempixel.com/640/160/?68438",
                    "description": "Quo adipisci est ut error aut molestiae provident id. Et asperiores nisi sunt vel nobis molestias quia. Neque pariatur qui doloremque autem temporibus mollitia.",
                    "pinned_post_id": 1,
                    "created_at": "2020-05-31 18:53:32",
                    "updated_at": "2020-05-31 18:53:32"
                }
            },
            {
                "id": 3,
                "content": "3",
                "user_id": 2,
                "post_id": 1,
                "reply_id": 1,
                "parent_1_id": 1,
                "parent_2_id": null,
                "parent_3_id": null,
                "created_at": "2020-05-31 18:37:15",
                "updated_at": "2020-05-31 18:53:35",
                "author": {
                    "id": 2,
                    "name": "testuser",
                    "slug": "testuser",
                    "image": "https://lorempixel.com/120/120/?14081",
                    "banner": "https://lorempixel.com/640/160/?68438",
                    "description": "Quo adipisci est ut error aut molestiae provident id. Et asperiores nisi sunt vel nobis molestias quia. Neque pariatur qui doloremque autem temporibus mollitia.",
                    "pinned_post_id": 1,
                    "created_at": "2020-05-31 18:53:32",
                    "updated_at": "2020-05-31 18:53:32"
                }
            },
            {
                "id": 2,
                "content": "2",
                "user_id": 2,
                "post_id": 1,
                "reply_id": 1,
                "parent_1_id": 1,
                "parent_2_id": null,
                "parent_3_id": null,
                "created_at": "2020-05-31 18:37:04",
                "updated_at": "2020-05-31 18:53:34",
                "author": {
                    "id": 2,
                    "name": "testuser",
                    "slug": "testuser",
                    "image": "https://lorempixel.com/120/120/?14081",
                    "banner": "https://lorempixel.com/640/160/?68438",
                    "description": "Quo adipisci est ut error aut molestiae provident id. Et asperiores nisi sunt vel nobis molestias quia. Neque pariatur qui doloremque autem temporibus mollitia.",
                    "pinned_post_id": 1,
                    "created_at": "2020-05-31 18:53:32",
                    "updated_at": "2020-05-31 18:53:32"
                }
            },
            {
                "id": 1,
                "content": "1",
                "user_id": 2,
                "post_id": 1,
                "reply_id": null,
                "parent_1_id": null,
                "parent_2_id": null,
                "parent_3_id": null,
                "created_at": "2020-05-31 18:36:54",
                "updated_at": "2020-05-31 18:53:34",
                "author": {
                    "id": 2,
                    "name": "testuser",
                    "slug": "testuser",
                    "image": "https://lorempixel.com/120/120/?14081",
                    "banner": "https://lorempixel.com/640/160/?68438",
                    "description": "Quo adipisci est ut error aut molestiae provident id. Et asperiores nisi sunt vel nobis molestias quia. Neque pariatur qui doloremque autem temporibus mollitia.",
                    "pinned_post_id": 1,
                    "created_at": "2020-05-31 18:53:32",
                    "updated_at": "2020-05-31 18:53:32"
                }
            }
        ];
    }

    render() {
        let post = this.props.post;
        return (
            <div>
                <h1>{post.title}</h1>
                <p>{post.excerpt}</p>
                <div>
                    {post.content}
                </div>
                <div>
                    <i>
                    {post.created_at}
                    </i>
                    <br />
                    <b>Rating: {post.rating}</b>
                </div>

                <div>
                    { this.comments.map((comment) => {
                        return (
                            <div id={'comment_' + comment.id}>
                                { (comment.reply_id) && (<p><a href={'#comment_' + comment.reply_id}>Reply to {comment.reply_id}</a></p>)}
                                <p>Id: {comment.id}</p>
                                <p>Name: {comment.author.name}</p>
                                <p>Content: {comment.content}</p>
                                <p>Created at: {comment.created_at}</p>
                            </div>
                        );
                    })}
                </div>
            </div>
        );
    }
}

const mapStateToProps = (state, props) => {
    let currentPost = null;

    let sluggedId = props.match.params.slugged_id;
    let postId = sluggedId.split('-')[0];

    for (let post of state.posts) {
        if (Number(post.id) === Number(postId)) {
            currentPost = post;
        }
    }

    return {
        post: currentPost,
    }
};

export default connect(mapStateToProps, null)(PostView);
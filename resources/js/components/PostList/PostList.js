import React, {Component} from 'react';
import {connect} from 'react-redux';

class PostList extends Component {
    constructor(props) {
        super(props);

        this.state = {
            posts: this.props.posts
        }
    }

    render() {
        return (
            <div>
                { this.state.posts.map((post) => {
                        return (
                            <PostListElement key={post.id}
                                             title={post.title}
                                             excerpt={post.excerpt}
                                             likes={post.like_count}
                                             bookmarks={post.bookmark_count}
                                             created_at={post.created_at}
                            />
                        )
                    })
                }
            </div>
        );
    }
}

const PostListElement = (props) => {
    return (
        <div>
            <h3>{props.title}</h3>
            <p>{props.excerpt}</p>
            <p>{props.created_at}</p>
            <p>Like</p>
            <p>{props.likes}</p>
            <p>Dislike</p>
            <p>Bookmark</p>
            <p>{props.bookmark_count}</p>
        </div>
    )
};

const mapStateToProps = state => {
    console.log(state);
    return {
        posts: state.posts,
    }
};

export default connect(mapStateToProps, null)(PostList);
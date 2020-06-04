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
                                             rating={post.rating}
                                             bookmarks_count={post.bookmarks_count}
                                             comments_count={post.comments_count}
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
            <h3>Title: {props.title}</h3>
            <p>Excerpt: {props.excerpt}</p>
            <p>Created at: {props.created_at}</p>
            <p>Like</p>
            <p>Rating: {props.rating}</p>
            <p>Dislike</p>
            <p>Bookmark</p>
            <p>Bookmarks count: {props.bookmarks_count}</p>
            <p>Comments count: {props.comments_count}</p>
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
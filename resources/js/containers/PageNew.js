import React from 'react';
import apiRouter from "../routes/ApiRouter";
import PostList from "../components/PostList/PostList";

class PageNew extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            posts: [],
        }
    }

    componentDidMount() {
        axios.get(apiRouter.route('pageNew'))
            .then((response) => {
                this.setState({
                    posts: response.data,
                });
            });
    }

    render() {
        return (
            <div>New
                <PostList posts={this.state.posts} />
            </div>
        );
    }
}

export default PageNew;
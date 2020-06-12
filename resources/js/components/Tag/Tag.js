import React from 'react';
import apiRouter from "../../routes/ApiRouter";
import PostList from "../PostList/PostList";

class Tag extends React.Component {

    constructor(props) {
        super(props);

        this.state = {
            tag: {},
        };
    }

    componentDidMount() {
        const { tag } = this.props.match.params;
        axios.get(apiRouter.route('tag', [tag]))
            .then((response) => {
                this.setState({
                    tag: response.data,
                });
            });
    }

    render() {
        let { tag } = this.state;
        return (
            <div>
                <p>{tag.title}</p>
                <PostList posts={tag.posts} />
            </div>
        );
    }
}

export default Tag;

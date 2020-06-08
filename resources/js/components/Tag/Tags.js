import React from 'react';
import {Link} from "react-router-dom";
import apiRouter from "../../routes/ApiRouter";
import webRouter from "../../routes/WebRouter";

class Tags extends React.Component {

    constructor(props) {
        super(props);

        this.state = {
            tags: [],
        };
    }

    componentDidMount() {
        axios.get(apiRouter.route('tags'))
            .then((response) => {
                this.setState({
                    tags: response.data,
                });
            });
    }

    render() {
        const { tags = [] } = this.state;
        return (
            <div>
                { tags.map((tag) => {
                    return (
                        <React.Fragment key={tag.id}>
                            <div>{tag.title}</div>
                            <Link to={webRouter.route('tag', tag.title)}>
                                Go
                            </Link>
                            <hr />
                        </React.Fragment>
                    );
                })}
            </div>
        );
    }
}

export default Tags;
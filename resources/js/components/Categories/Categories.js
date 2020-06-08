import React from "react";
import {Link} from "react-router-dom";
import apiRouter from "../../routes/ApiRouter";
import webRouter from "../../routes/WebRouter";

class Categories extends React.Component {

    constructor(props) {
        super(props);

        this.state = {
            categories: [],
        };
    }

    componentDidMount() {
        axios.get(apiRouter.route('categories'))
            .then((response) => {
                this.setState({
                    categories: response.data,
                });
            });
    }

    render() {
        let { categories = [] } = this.state;
        return (
            <div>
                { categories.map((category) => {
                    return (
                        <div>
                            <h2>{category.title}</h2>
                            <p>{category.description}</p>
                            <p>{category.image}</p>
                            <Link to={webRouter.route('category', [category.slug])}>
                                Go
                            </Link>
                        </div>
                    );
                })}
            </div>
        );
    }
}

export default Categories;
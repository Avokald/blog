import React from "react";
import {connect} from 'react-redux';
import {absoluteToRelativePath} from "../../helpers/urlhelper";
import {Link} from "react-router-dom";

class Categories extends React.Component {
    render() {
        let categories = this.props.categories;
        return (
            <div>
                { categories.map((category) => {
                    return (
                        <div>
                            <h2>{category.title}</h2>
                            <p>{category.description}</p>
                            <p>{category.image}</p>
                            <Link to={absoluteToRelativePath(category.link)}>
                                Go
                            </Link>
                        </div>
                    );
                })}
            </div>
        );
    }
}

const mapStateToProps = (state) => {
    return {
        categories: state.categories,
    }
};

export default connect(mapStateToProps, null)(Categories);
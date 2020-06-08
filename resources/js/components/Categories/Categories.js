import React from "react";
import {Link} from "react-router-dom";
import {connect} from 'react-redux';
import webRouter from "../../routes/WebRouter";
import {getCategories} from "../../actions";

class Categories extends React.Component {

    componentDidMount() {
        this.props.fetchCategories();
    }

    render() {
        let { categories = [] } = this.props;
        return (
            <div>
                { categories.map((category) => {
                    return (
                        <div key={category.id}>
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

const mapStateToProps = (state) => ({
    categories: state.categories.data,
});

const mapDispatchToProps = (dispatch) => ({
    fetchCategories: () => dispatch(getCategories()),
});

export default connect(mapStateToProps, mapDispatchToProps)(Categories);
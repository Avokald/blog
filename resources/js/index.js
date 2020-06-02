import React from 'react';
import ReactDOM from 'react-dom';
import {Provider} from 'react-redux';
import PostList from "./components/PostList/PostList";
import store from './store/index';
import {BrowserRouter, Link, Route, Switch} from "react-router-dom";

const app = (
    <Provider store={store}>
        <BrowserRouter>
            <div>Hello
                <div>
                    <Link to="/react">Click</Link>
                </div>
                <Switch>
                    <Route exact path="/" component={PostList} />
                </Switch>
            </div>
        </BrowserRouter>
    </Provider>
);

ReactDOM.render(app, document.getElementById('app'));
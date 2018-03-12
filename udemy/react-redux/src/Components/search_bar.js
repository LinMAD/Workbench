import React from "react";
import {Component} from "react/lib/ReactIsomorphic";

class SearchBar extends Component {
    constructor(props) {
        super(props);

        this.state = { term: '' }
    }

    render() {
        return (
            <div className="col-md-12 search-bar">
                Search video:&nbsp;
                <input
                    value={this.state.term}
                    onChange={event => this.setState({ term: event.target.value})}
                />
            </div>
        );
    }
}

export default SearchBar;

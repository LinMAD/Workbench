import React from "react";
import {Component} from "react/lib/ReactIsomorphic";

class SearchBar extends Component {
    constructor(props) {
        super(props);

        this.state = { term: '' }
    }

    render() {
        return (
            <div>
                <input
                    value={this.state.term}
                    onChange={event => this.setState({ term: event.target.value})}
                />
                &nbsp;Value of input: { this.state.term }
            </div>
        );
    }
}

export default SearchBar;

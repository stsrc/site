//TODO: sql on github.io?

import './App.css';
import pic_github from './assets/github.svg';
import pic_mail from './assets/mail.svg';
import pic_linkedin from './assets/linkedin.svg';

import React, { Component } from 'react'
import ReactMarkdown from 'react-markdown'
import pizzaPath from './assets/blog/pizza.md'

class TestName extends Component {
  constructor(props) {
    super(props)

    this.state = { terms: null }
  }

  componentWillMount() {
    fetch(pizzaPath).then((response) => response.text()).then((text) => { //TODO: warning in console
      this.setState({ terms: text })
    })
  }

  render() {
    return (
      <ReactMarkdown>{this.state.terms}</ReactMarkdown>
    )
  }
}

function App() {
  return (
    <div id="container">
      <div id="one">
	Konrad Gotfryd's site<br/>
	Embedded developer willing to learn about other technologies (android, web) 
	<div id="svglinks">
  	  <a href="https://github.com/stsrc"><img src={pic_github} alt="github" style={{
	    width: '24px',
	    height: '24px'
	  }}/></a>
  	  <a href="https://linkedin.com/in/konrad-gotfryd-4aa205136"><img src={pic_linkedin} alt="linkedin" style={{
	    width: '24px',
	    height: '24px'
	  }}/></a>
  	  <a href="mailto:kgotfryd.4l@gmail.com"><img src={pic_mail} alt="mail" style={{
	    width: '24px',
	    height: '24px'
	  }}/></a>
	</div>
      </div>
      <div id="two">
 	<div id="header">
	  <h1>Yet another fancy site.</h1>
	</div>
        <TestName />
      </div>
    </div>
  );
}

export default App;

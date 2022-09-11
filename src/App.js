import './App.css';
import pic_github from './assets/github.svg';
import pic_mail from './assets/mail.svg';
import pic_linkedin from './assets/linkedin.svg';

function App() {
  return (
    <div id="container">
      <div id="one">
	Konrad Gotfryd site<br/>
	Open minded embedded programmer willing to learn about other technologies (android, web) 
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
        Hello world.
      </div>
    </div>
  );
}

export default App;

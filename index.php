
<style>
    .signup-button {
        text-decoration: none;
        border-radius: 3vw;
        border: solid;
        color: rgb(122, 135, 100);
        width: 20vw;
        height: 5vw;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3vw;
        background-color: rgb(226, 226, 226);
        font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif;
        transition: color 1s, background-color 1s;
        position: absolute;
        bottom: 500;
        rotate: 40deg;
        left: 700;
    }

    .login-button {
        text-decoration: none;
        border-radius: 1vw;
        border: solid;
        color: rgb(133, 131, 238);
        width: 14vw;
        height: 5vw;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3vw;
        background-color: rgb(252, 199, 199);
        font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
        transition: color 1s, background-color 1s;
        position: absolute;
        bottom: 350;
        rotate: 80deg;
        left: 300;
    }

    .or {
        border: solid;
        width: 2vw;
        height: 2vw;
        border-radius: 2vw;
        border-color: black;
        border-width: 0.1vw;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5vw;
        position: absolute;
        bottom: 450;
        rotate: 80deg;
        left: 500;
    }

    .login-button:hover {
        border: solid;
        color: rgb(122, 135, 100);
        font-size: 3vw;
        background-color: rgb(226, 226, 226);
        font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif;
    }

    .signup-button:hover {
        border: solid;
        color: rgb(133, 131, 238);
        font-size: 3vw;
        background-color: rgb(252, 199, 199);
        font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
    }
</style>

<a href="signup.php" class="signup-button" id="signup">
    Sign up
</a>

<div class="or" id="or">
    Or
</div>

<a href="login.php" class="login-button" id="login">
    Login
</a>

<script>
    fall("login");
    fall("or");
    fall("signup");

    function fall (elementName) {
        let el = document.getElementById(elementName);
        let elHeight = parseInt(window.getComputedStyle(el, null).getPropertyValue("bottom"));
        let elAngleFull = parseInt(window.getComputedStyle(el, null).getPropertyValue("rotate"));
        let elRadius = parseInt(window.getComputedStyle(el, null).getPropertyValue("border-radius"));
        let elWidth = parseInt(window.getComputedStyle(el, null).getPropertyValue("width"));
        let elHeightDim = parseInt(window.getComputedStyle(el, null).getPropertyValue("height"));
        let elLeft = parseInt(window.getComputedStyle(el, null).getPropertyValue("left"));
        let angleRatio = getRatio(elAngleFull);
        let elAngle = getAngle(elAngleFull);
        let halfCrosslineLen = Math.sqrt(Math.pow(elHeightDim/2, 2)+Math.pow(elWidth/2, 2));

        let betaAngle = Math.atan((elHeightDim/2)/(elWidth/2))*180/Math.PI;
        let trigoLength = Math.cos((90-(elAngle+betaAngle))*Math.PI/180)*halfCrosslineLen - elHeightDim/2 - (Math.sqrt(2)*elRadius - elRadius)*angleRatio;
        let tetiva = 2*halfCrosslineLen*Math.sin((elAngle/2)*Math.PI/180);
        let diff = Math.sqrt(Math.pow(tetiva, 2) - Math.pow((trigoLength), 2));
        let afterFallPos = elLeft - diff;

        const acc = 9.8;
        let mass = 10;
        let power = mass*acc;
        
        let currTime = 0;
        let currHeight = 0;
        let angle = elAngleFull;
        let amp = 1;

        let move = setInterval(function(){
            let hiddenPart = trigoLength ;
            currHeight = elHeight - 0.5*acc*currTime*currTime;
            el.style.bottom = currHeight;
            currTime += 0.1;
            if (currHeight < hiddenPart) {
                el.style.bottom = hiddenPart;
                currHeight = hiddenPart;
                elHeight = currHeight;
                el.style.transformOrigin = '100% 100%';
                el.style.left = afterFallPos;
                el.style.bottom = 0;
                // clearInterval(move);
            }
            if (currHeight == hiddenPart && elAngleFull - angle < elAngleFull) {
                if (angle-amp < 0) {
                    el.style.rotate = 0+'deg';
                    return;
                }
                amp+=0.2;
                angle -= amp;
                el.style.rotate = angle+'deg';
            }
            
        },10)
    }

    function getRatio (elAngle) {
        for (let i = 0; i < 360/45; i++) {
            if (elAngle >= i*45 && elAngle <= (i+1)*45) {
                return ((i+1)*45-elAngle)/45;
                break;
            }
        }
    }

    function getAngle (elAngle) {
        let angle = 0;
        for (let i = 0; i < 360/90; i++) {
            if (elAngle >= i*90) {
                angle = elAngle-i*90;
                if (i == 1 || i == 3) {
                    angle = 90 - angle;
                }
            }
        }
        return angle;
    }
    
</script>
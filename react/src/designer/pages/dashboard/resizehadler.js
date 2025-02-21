import styleElement from "./styleElement";
import update from "./updatestyle";

let isResizing = false;
function resizehadler (event)  {
  
  

  const { offsetX, offsetY, target } = event;
    const borderWidth = 20;
    const borderh = 20;

    // Check if clicked on the border
    if (
        offsetX >= target.clientWidth - borderWidth &&
     
        offsetY >= target.clientHeight - borderh
    ) {

      
        isResizing = true;

        // Store initial mouse position
        const initialMouseX = event.clientX;
        const initialMouseY = event.clientY;
        const initialWidth = target.offsetWidth;
        const initialHeight = target.offsetHeight;
        const parent = target.parentElement;
        // Mouse move event to resize the box
        const mouseMoveHandler = (moveEvent) => {
          const dx = (moveEvent.clientX+50 )- initialMouseX;
          const dy = moveEvent.clientY - initialMouseY;
          target.classList.add("div")
          // Calculate new dimensions in pixels
          const newWidth = initialWidth + dx;
          const newHeight = initialHeight + dy;
    
          // Set width and height as percentages based on parent dimensions
          const parentWidth = parent.clientWidth;
          const parentHeight = parent.clientHeight;
    
          const newWidthPercent = (newWidth / parentWidth) * 100;
          const newHeightPercent = (newHeight / parentHeight) * 100;
            
            update(styleElement,target,{position:"relative",
              width:(newWidthPercent)+"%",
              height:(newHeightPercent)+"%"
          })
        };

        // Mouse up event to stop resizing
        const mouseUpHandler = () => {
            isResizing = false;
            document.removeEventListener('mousemove', mouseMoveHandler);
            document.removeEventListener('mouseup', mouseUpHandler);
            target.classList.remove("div")
        };

        document.addEventListener('mousemove', mouseMoveHandler);
        document.addEventListener('mouseup', mouseUpHandler);
    }
}

export default resizehadler
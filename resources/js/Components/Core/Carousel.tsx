import {Image} from "@/types";
import {useEffect, useState} from "react";

function Carousel({images}: { images: Image[] }) {
  const [selectedImage, setSelectedImage] = useState<Image>(images[0]);

  useEffect(() => {
    setSelectedImage(images[0]);
  }, [images]);

  return (
    <>
      <div className="flex flex-col sm:flex-row items-start gap-8">
        <div className="order-2 sm:order-1 flex flex-row sm:flex-col items-center gap-2 py-2">
          {images.map((image, i) => (
            <button onClick={ev => setSelectedImage(image)}
                    className=
                      {'border-2 ' +
                        (selectedImage.id === image.id ? 'border-blue-500' : 'hover:border-blue-500')
                      }
                    key={image.id}>
              <img src={image.thumb} alt="" className="w-[64px] h-[64px] object-contain"/>
            </button>
          ))}
        </div>
        <div className="order-1 sm:order-2 carousel w-full">
          <div className="carousel-item w-full">
            <img
              src={selectedImage.large}
              className="w-full h-[600px] object-contain"/>
          </div>
        </div>
      </div>
    </>
  )
}

export default Carousel;

import {
  forwardRef,
  InputHTMLAttributes,
  useImperativeHandle,
  useRef,
  useState,
} from "react";

interface FileInputProps extends InputHTMLAttributes<HTMLInputElement> {
  label?: string;
  className?: string;
}

const FileInput = forwardRef<HTMLInputElement, FileInputProps>(
  ({ label = "اسحب وأفلت الملف هنا أو اضغط للاختيار", className = "", ...props }, ref) => {
    const localRef = useRef<HTMLInputElement>(null);
    const [fileName, setFileName] = useState<string | null>(null);
    const [isDragging, setIsDragging] = useState(false);

    useImperativeHandle(ref, () => localRef.current as HTMLInputElement);

    const handleFiles = (files: FileList | null) => {
      if (files && files.length > 0) {
        setFileName(files[0].name);
      } else {
        setFileName(null);
      }
    };

    const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
      handleFiles(e.target.files);
      props.onChange?.(e);
    };

    const handleDragOver = (e: React.DragEvent<HTMLDivElement>) => {
      e.preventDefault();
      setIsDragging(true);
    };

    const handleDragLeave = (e: React.DragEvent<HTMLDivElement>) => {
      e.preventDefault();
      setIsDragging(false);
    };

    const handleDrop = (e: React.DragEvent<HTMLDivElement>) => {
      e.preventDefault();
      setIsDragging(false);
      handleFiles(e.dataTransfer.files);

      // تحديث قيمة input الأصلي
      if (localRef.current) {
        localRef.current.files = e.dataTransfer.files;
      }
    };

    return (
      <div>
        <div
          className={`w-full border-2 border-dashed rounded-lg p-6 text-center cursor-pointer transition-colors ${
            isDragging ? "border-blue-400 bg-blue-50" : "border-gray-300"
          } ${className}`}
          onClick={() => localRef.current?.click()}
          onDragOver={handleDragOver}
          onDragLeave={handleDragLeave}
          onDrop={handleDrop}
        >
          <p className="text-gray-500">{label}</p>
          {fileName && <p className="mt-2 text-gray-700">{fileName}</p>}
        </div>
        <input
          {...props}
          ref={localRef}
          type="file"
          className="hidden"
          onChange={handleChange}
        />
      </div>
    );
  }
);

export default FileInput;

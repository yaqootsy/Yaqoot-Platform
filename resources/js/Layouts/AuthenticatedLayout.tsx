import {Link, usePage} from '@inertiajs/react';
import {PropsWithChildren, ReactNode, useEffect, useRef, useState} from 'react';
import Navbar from "@/Components/App/Navbar";

export default function AuthenticatedLayout(
  {
    header,
    children,
  }: PropsWithChildren<{ header?: ReactNode }>) {
  const props = usePage().props;
  const user = props.auth.user;

  const [successMessages, setSuccessMessages] = useState<any[]>([]);
  const timeoutRefs = useRef<{ [key: number]: ReturnType<typeof setTimeout> }>({}); // Store timeouts by message ID

  const [showingNavigationDropdown, setShowingNavigationDropdown] =
    useState(false);

  useEffect(() => {
    if (props.success.message) {
      const newMessage = {
        ...props.success,
        id: props.success.time, // Use time as unique identifier
      };

      // Add the new message to the list
      setSuccessMessages((prevMessages) => [newMessage, ...prevMessages]);

      // Set a timeout for this specific message
      const timeoutId = setTimeout(() => {
        // Use a functional update to ensure the latest state is used
        setSuccessMessages((prevMessages) =>
          prevMessages.filter((msg) => msg.id !== newMessage.id)
        );
        // Clear timeout from refs after execution
        delete timeoutRefs.current[newMessage.id];
      }, 5000);

      // Store the timeout ID in the ref
      timeoutRefs.current[newMessage.id] = timeoutId;
    }

  }, [props.success]);

  return (
    <div className="min-h-screen bg-gray-100 dark:bg-gray-900">
      <Navbar/>

      {props.error && (
        <div className="container mx-auto px-8 mt-8 ">
          <div className="alert alert-error">
            {props.error}
          </div>
        </div>
      )}

      {successMessages.length > 0 && (
        <div className="toast toast-top toast-end z-[1000] mt-16">
          {successMessages.map((msg) => (
            <div className="alert alert-success" key={msg.id}>
              <span>{msg.message}</span>
            </div>
          ))}
        </div>
      )}

      <main>{children}</main>
    </div>
  );
}

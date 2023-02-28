import React, { useState, useEffect } from 'react';
import PropTypes from 'prop-types';
import './Modal.css';
import {AiOutlineCloseSquare} from "react-icons/ai";

function Modal({ isOpen, onClose,title, children }) {
    const [showModal, setShowModal] = useState(isOpen);

    useEffect(() => {
        setShowModal(isOpen);
    }, [isOpen]);

    const handleClose = () => {
        setShowModal(false);
        onClose();
    };

    return (
        <>
            {showModal && (
                <div className="modal-overlay">
                    <div className="modal bg-[#d1d5db] w-[96vw] sm:w-[80vw] md:w-1/2">
                        {title ? <div className="text-center text-2xl">{title}</div> : ''}
                        <div className="modal-content">{children}</div>
                        <button className="close-button text-rose-900" onClick={handleClose}>
                            <AiOutlineCloseSquare />
                        </button>
                    </div>
                </div>
            )}
        </>
    );
}

Modal.propTypes = {
    isOpen: PropTypes.bool.isRequired,
    onClose: PropTypes.func.isRequired,
    children: PropTypes.node.isRequired,
};

export default Modal;

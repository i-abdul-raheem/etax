'use client'

import { motion } from 'framer-motion'
import { ArrowRight, Phone, MessageCircle, Clock } from 'lucide-react'
import Link from 'next/link'

export default function CTA() {
  return (
    <section className="py-20 bg-gradient-to-r from-primary-600 to-primary-800 text-white relative overflow-hidden">
      {/* Background Elements */}
      <div className="absolute inset-0">
        <div className="absolute top-0 left-0 w-full h-full bg-black/10"></div>
        <div className="absolute top-20 right-20 w-72 h-72 bg-white/5 rounded-full"></div>
        <div className="absolute bottom-20 left-20 w-72 h-72 bg-white/5 rounded-full"></div>
      </div>

      <div className="relative z-10 container-custom text-center">
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true }}
          transition={{ duration: 0.8 }}
          className="max-w-4xl mx-auto"
        >
          <h2 className="text-4xl md:text-6xl font-bold mb-6">
            Get <span className="text-accent-300">FREE</span> Tax Advice Today!
          </h2>
          
          <p className="text-xl md:text-2xl text-primary-100 mb-8 leading-relaxed">
            eTax consultants offers you FREE consultation with our principal advocate to help you make 
            informed legal decisions! No problem is too great!
          </p>

          <motion.div 
            className="flex flex-col sm:flex-row gap-4 justify-center items-center mb-12"
            initial={{ opacity: 0, y: 20 }}
            whileInView={{ opacity: 1, y: 0 }}
            viewport={{ once: true }}
            transition={{ duration: 0.8, delay: 0.2 }}
          >
            <Link href="/contact" className="bg-accent-500 hover:bg-accent-600 text-white font-bold py-4 px-8 rounded-lg text-lg transition-all duration-200 transform hover:scale-105 hover:shadow-lg group">
              Get Free Advice!
              <ArrowRight className="ml-2 h-6 w-6 inline group-hover:translate-x-1 transition-transform" />
            </Link>
            <Link href="/services" className="bg-white/20 hover:bg-white/30 text-white font-medium py-4 px-8 rounded-lg text-lg border-2 border-white/30 transition-all duration-200">
              Learn More
            </Link>
          </motion.div>

          <motion.div 
            className="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-4xl mx-auto"
            initial={{ opacity: 0, y: 20 }}
            whileInView={{ opacity: 1, y: 0 }}
            viewport={{ once: true }}
            transition={{ duration: 0.8, delay: 0.4 }}
          >
            <div className="flex flex-col items-center text-center">
              <div className="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mb-4">
                <Phone className="w-8 h-8 text-white" />
              </div>
              <h3 className="text-xl font-semibold mb-2">Call Us Now</h3>
              <p className="text-primary-100">+92 21 3582 1757</p>
            </div>
            
            <div className="flex flex-col items-center text-center">
              <div className="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mb-4">
                <MessageCircle className="w-8 h-8 text-white" />
              </div>
              <h3 className="text-xl font-semibold mb-2">Email Us</h3>
              <p className="text-primary-100">info@taxpulse-pakistan.com</p>
            </div>
            
            <div className="flex flex-col items-center text-center">
              <div className="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mb-4">
                <Clock className="w-8 h-8 text-white" />
              </div>
              <h3 className="text-xl font-semibold mb-2">24/7 Support</h3>
              <p className="text-primary-100">Always Available</p>
            </div>
          </motion.div>
        </motion.div>
      </div>
    </section>
  )
}
